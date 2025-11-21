@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Filter Kategori -->
            <div class="lg:col-span-1">
                <div class="sticky top-20 max-h-screen overflow-y-auto">
                    <div class="space-y-2">
                        <a href="#" class="block w-full px-4 py-3 text-left text-sm font-medium rounded-lg bg-blue-500 text-white active" data-cat="all">Semua</a>
                        @foreach(\App\Models\Category::all() as $cat)
                            <a href="#" class="block w-full px-4 py-3 text-left text-sm font-medium text-gray-700 hover:bg-blue-50 rounded-lg cat-filter transition-colors" data-cat="{{ $cat->id }}">{{ $cat->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Produk Grid -->
            <div class="lg:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="product-grid">
                    @forelse($products as $product)
                    <div class="product-item" data-cat="{{ $product->category_id }}">
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border border-blue-200 overflow-hidden h-full flex flex-col">
                            <div class="p-4 flex flex-col flex-grow justify-between text-center">
                                <h6 class="font-semibold text-gray-800 mb-2">{{ $product->name }}</h6>
                                <p class="text-green-600 font-bold text-lg mb-3">Rp {{ number_format($product->price) }}</p>
                                <p class="text-gray-500 text-sm mb-4 flex-grow">Stok: {{ $product->stock }}</p>
                                @if($product->stock > 0)
                                    <button class="w-full py-2 px-4 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition-colors add-to-cart"
                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}">
                                        + Tambah
                                    </button>
                                @else
                                    <span class="block w-full py-2 px-4 bg-red-500 text-white text-sm font-medium rounded-md">Stok Habis</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <h5 class="text-gray-500 text-lg">Tidak ada produk tersedia.</h5>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Keranjang -->
            <div class="lg:col-span-1">
                <div class="sticky top-20">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="bg-blue-500 text-white px-4 py-3 rounded-t-lg">
                            <h5 class="mb-0 font-semibold">Keranjang Belanja ({{ count(session('cart', [])) }})</h5>
                        </div>
                        <div class="p-0">
                            <div id="cart-items" class="p-3 max-h-96 overflow-y-auto">
                                <!-- Diisi JS -->
                            </div>
                            <hr class="my-0 border-gray-200">
                            <div class="p-3">
                                <div class="flex justify-between items-center fw-bold text-lg mb-3 text-gray-800">
                                    <span>Total:</span>
                                    <span id="total-amount">Rp 0</span>
                                </div>
                                <button class="w-full py-3 px-4 bg-green-500 text-white font-semibold rounded-b-lg hover:bg-green-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" id="checkout-btn" disabled>
                                    Bayar (Rp <span id="total-pay">0</span>)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pembayaran -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Proses Pembayaran</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Total Belanja:</span>
                                    <span class="text-blue-500 font-bold text-xl">Rp <span id="modal-total">0</span></span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Uang Bayar (Rp):</label>
                                    <input type="number" id="pay-amount" class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="0" placeholder="Masukkan nominal" value="0">
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Kembalian:</span>
                                    <span class="text-green-600 font-bold text-xl">Rp <span id="change-amount">0</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closePaymentModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                    <button type="button" onclick="processPayment()" class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-3 inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed" id="process-payment" disabled>
                        Proses Transaksi & Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<script>
$(document).ready(function() {
    let cart = JSON.parse(localStorage.getItem('pos-cart') || '[]');

    // Filter kategori
    $(document).on('click', '.cat-filter', function(e) {
        e.preventDefault();
        $('.cat-filter').removeClass('active bg-blue-500 text-white');
        $('.cat-filter').addClass('hover:bg-blue-50');
        $(this).addClass('active bg-blue-500 text-white').removeClass('hover:bg-blue-50');
        let catId = $(this).data('cat');
        $('.product-item').hide();
        if (catId === 'all') {
            $('.product-item').fadeIn();
        } else {
            $(`.product-item[data-cat="${catId}"]`).fadeIn();
        }
    });

    // Tambah ke cart
    $(document).on('click', '.add-to-cart', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let price = $(this).data('price');

        let existing = cart.find(item => item.id === id);
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ id, name, price, qty: 1 });
        }

        localStorage.setItem('pos-cart', JSON.stringify(cart));
        renderCart();
        iziToast.success({
            title: 'Ditambahkan!',
            message: `${name} x1 ke keranjang`,
            position: 'topRight',
            timeout: 3000
        });
    });

    // Render cart
    function renderCart() {
        let $cartItems = $('#cart-items');
        $cartItems.empty();
        let total = 0;

        if (cart.length === 0) {
            $cartItems.html('<p class="text-center text-gray-500 py-3">Keranjang kosong</p>');
        } else {
            cart.forEach((item, index) => {
                let subtotal = item.price * item.qty;
                total += subtotal;

                $cartItems.append(`
                    <div class="bg-gray-50 rounded-lg p-3 mb-2">
                        <div class="flex justify-content-between align-items-center">
                            <div>
                                <strong class="text-gray-800 block">${item.name}</strong>
                                <small class="text-gray-500 block">Rp ${item.price.toLocaleString()} x ${item.qty}</small>
                            </div>
                            <div class="text-end">
                                <strong class="text-blue-600 block">Rp ${subtotal.toLocaleString()}</strong>
                                <button class="btn btn-sm btn-outline-danger remove-item mt-1" data-index="${index}">Hapus</button>
                            </div>
                        </div>
                    </div>
                `);
            });
        }

        $('#total-amount, #total-pay, #modal-total').text(total.toLocaleString());
        $('#checkout-btn').prop('disabled', total === 0);
    }

    // Hapus item
    $(document).on('click', '.remove-item', function() {
        let index = $(this).data('index');
        let removedName = cart[index].name;
        cart.splice(index, 1);
        localStorage.setItem('pos-cart', JSON.stringify(cart));
        renderCart();
        iziToast.info({
            title: 'Dihapus!',
            message: `${removedName} dihapus dari keranjang`,
            position: 'topRight',
            timeout: 3000
        });
    });

    // Initial render
    renderCart();

    // Checkout
    $('#checkout-btn').click(function() {
        let total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        if (total === 0) return;
        $('#modal-total').text(total.toLocaleString());
        $('#pay-amount').val(total);
        calculateChange();
        openPaymentModal();
    });

    // Hitung kembalian
    $('#pay-amount').on('input', calculateChange);

    function calculateChange() {
        let total = parseInt($('#modal-total').text().replace(/\D/g, '')) || 0;
        let pay = parseInt($('#pay-amount').val()) || 0;
        let change = pay - total;
        $('#change-amount').text(change.toLocaleString());
        $('#process-payment').prop('disabled', change < 0);
    }

    // Proses pembayaran
    function processPayment() {
        let total = parseInt($('#modal-total').text().replace(/\D/g, '')) || 0;
        let pay = parseInt($('#pay-amount').val()) || 0;

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        $.post('{{ route("sale.store") }}', {
            cart: JSON.stringify(cart),
            total: total,
            pay: pay
        })
        .done(function(response) {
            if (response.success) {
                iziToast.success({
                    title: 'Sukses!',
                    message: 'Transaksi selesai. Struk dibuka di tab baru.',
                    position: 'topRight',
                    timeout: 5000
                });
                window.open('/sale/receipt/' + response.sale_id, '_blank');
                cart = [];
                localStorage.removeItem('pos-cart');
                renderCart();
                closePaymentModal();
                $('#pay-amount').val(0);
            } else {
                iziToast.error({
                    title: 'Error!',
                    message: response.error || 'Gagal memproses transaksi.',
                    position: 'topRight'
                });
            }
        })
        .fail(function() {
            iziToast.error({
                title: 'Error!',
                message: 'Koneksi gagal. Coba lagi.',
                position: 'topRight'
            });
        });
    }

    // Modal functions (vanilla)
    function openPaymentModal() {
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    // Bind modal close
    $('#pay-amount').on('input', function() {
        calculateChange();
    });

    document.querySelector('#process-payment').onclick = processPayment;
    document.querySelector('[data-bs-dismiss="modal"]').onclick = closePaymentModal;
});
</script>
@endpush