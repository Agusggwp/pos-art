<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|json',
            'total' => 'required|integer|min:0',
            'pay' => 'required|integer|min:0'
        ]);

        $cart = json_decode($request->cart);
        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong!'], 400);
        }

        $total = (int) $request->total;
        $pay = (int) $request->pay;
        $change = $pay - $total;

        if ($change < 0) {
            return response()->json(['error' => 'Uang tidak cukup!'], 400);
        }

        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'pay' => $pay,
                'change' => $change
            ]);

            foreach ($cart as $item) {
                $product = Product::findOrFail((int) $item->id);
                if ($product->stock < (int) $item->qty) {
                    throw new \Exception("Stok {$product->name} tidak cukup!");
                }

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => (int) $item->id,
                    'quantity' => (int) $item->qty,
                    'price' => (int) $item->price,
                    'subtotal' => (int) $item->price * (int) $item->qty
                ]);

                $product->decrement('stock', (int) $item->qty);
            }

            DB::commit();
            return response()->json(['success' => true, 'sale_id' => $sale->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function receipt($id)
    {
        $sale = Sale::with(['details.product', 'user'])->findOrFail($id);
        $pdf = Pdf::loadView('sales.receipt', compact('sale'))->setPaper('a4', 'portrait');
        return $pdf->stream('struk_' . $id . '.pdf');
    }

    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $sales = Sale::with(['user', 'details.product'])->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }
}