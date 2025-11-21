@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Daftar Produk</h1>
            <p class="text-sm text-gray-600 mt-1">Kelola stok dan detail produk dengan mudah.</p>
        </div>
        <a href="{{ route('products.create') }}"
            class="inline-flex items-center px-4 py-2 border border-indigo-600 text-indigo-600 bg-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Produk Baru
        </a>
    </div>

    <!-- Products Table -->
    @if($products->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Barcode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($product->price) }}</td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $product->stock > 10 ? 'bg-green-600 text-white' :
                                        ($product->stock > 0 ? 'bg-yellow-500 text-white' : 'bg-red-600 text-white') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $product->barcode ?? 'N/A' }}</td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('products.show', $product) }}"
                                    class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-blue-600 bg-blue-50 hover:bg-blue-100 text-xs font-medium rounded-md transition-all duration-200">
                                    Lihat
                                </a>

                                <a href="{{ route('products.edit', $product) }}"
                                    class="inline-flex items-center px-3 py-1.5 border border-yellow-500 text-yellow-700 bg-yellow-50 hover:bg-yellow-100 text-xs font-medium rounded-md transition-all duration-200">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Yakin hapus {{ $product->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-red-600 text-red-600 bg-red-50 hover:bg-red-100 text-xs font-medium rounded-md transition-all duration-200">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $products->links() }}
        </div>

    @else
        <!-- Empty State -->
        <div class="text-center py-12 bg-white rounded-xl shadow-lg">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 mb-4">
                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
            </div>

            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk</h3>
            <p class="mt-1 text-sm text-gray-600">Mulai dengan menambahkan produk pertama Anda.</p>

            <div class="mt-6">
                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center px-4 py-2 border border-indigo-600 text-indigo-600 bg-white text-sm font-medium rounded-md hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    Tambah sekarang
                </a>
            </div>
        </div>
    @endif

</div>
@endsection