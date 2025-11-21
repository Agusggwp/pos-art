<!DOCTYPE html>
<html>
<head>
    <title>Struk Penjualan #{{ $sale->id }}</title>
    <style>
        body { 
            font-family: 'Courier New', monospace; 
            font-size: 10px; 
            margin: 0; 
            padding: 8px; 
            width: 80mm; 
            max-width: 300px; 
            line-height: 1.2; 
            color: #000; 
            text-align: center;
            background: white;
        }
        .header { 
            margin-bottom: 12px; 
            border-bottom: 2px dashed #000; 
            padding-bottom: 6px;
        }
        .header h3 { 
            margin: 2px 0; 
            font-size: 14px; 
            font-weight: bold; 
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
        }
        .header p { 
            margin: 1px 0; 
            font-size: 9px; 
            line-height: 1.3;
        }
        .header .info { 
            font-size: 8px; 
            margin-top: 4px;
            border-top: 1px dotted #000;
            padding-top: 2px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 8px 0; 
            font-size: 9px;
            border: 1px solid #000;
        }
        th, td { 
            padding: 3px 2px; 
            text-align: left; 
            border-bottom: 1px solid #ddd; 
            vertical-align: top;
        }
        th { 
            text-align: center; 
            font-weight: bold; 
            background: #f5f5f5;
            border-bottom: 2px solid #000; 
            padding: 4px 2px;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .price { text-align: right; width: 20%; font-weight: bold; }
        .qty { text-align: center; width: 8%; }
        .subtotal { text-align: right; width: 25%; font-weight: bold; }
        .item-name { width: 47%; font-weight: 500; }
        .total-section { 
            margin-top: 12px; 
            border-top: 3px double #000; 
            padding-top: 6px; 
            text-align: right;
            font-weight: bold;
            font-size: 11px;
            line-height: 1.4;
        }
        .total-item { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 3px; 
            padding: 1px 0;
            border-bottom: 1px dotted #000;
        }
        .total-item:last-child { border-bottom: none; }
        .change { color: #006400; font-weight: bold; }
        .footer { 
            margin-top: 15px; 
            border-top: 2px dashed #000; 
            padding-top: 8px; 
            font-size: 8px; 
            line-height: 1.3;
            text-align: center;
        }
        .footer p { 
            margin: 1px 0; 
            font-style: italic;
        }
        .no-data { 
            text-align: center; 
            font-style: italic; 
            color: #666; 
            padding: 20px;
            font-size: 10px;
        }
        .barcode { 
            margin: 5px 0; 
            text-align: center; 
            font-family: 'Code 128', monospace; 
            font-size: 12px; 
            letter-spacing: 1px;
        }
        @media print { 
            body { margin: 0; padding: 2px; } 
            .no-print { display: none; }
        }
        @page { 
            margin: 0.2in; 
            size: 80mm auto; 
            margin-top: 0.1in;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>POS Laravel</h3>
        <p>Struk Penjualan #{{ $sale->id }}</p>
        <p>Tanggal: {{ $sale->created_at->format('d/m/Y H:i') }}</p>
        <p>Kasir: {{ $sale->user->name }}</p>
        <div class="info">
            Alamat Toko: Jl. Contoh No. 123, Kota<br>
            Telp: (021) 1234567
        </div>
    </div>

    <div class="barcode">
        *{{ $sale->id }}*
    </div>

    <table>
        <tr>
            <th class="item-name">Item</th>
            <th class="qty">Qty</th>
            <th class="price">Harga</th>
            <th class="subtotal">Subtotal</th>
        </tr>
        @forelse($sale->details as $detail)
        <tr>
            <td class="item-name">{{ $detail->product->name }}</td>
            <td class="qty">{{ $detail->quantity }}</td>
            <td class="price">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
            <td class="subtotal">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="no-data">Tidak ada item dalam penjualan ini.</td>
        </tr>
        @endforelse
    </table>

    <div class="total-section">
        <div class="total-item"><span>Total Item:</span><span>{{ $sale->details->sum('quantity') }} pcs</span></div>
        <div class="total-item"><span>Total:</span><span>Rp {{ number_format($sale->total, 0, ',', '.') }}</span></div>
        <div class="total-item"><span>Bayar:</span><span>Rp {{ number_format($sale->pay, 0, ',', '.') }}</span></div>
        <div class="total-item"><span class="change">Kembali:</span><span class="change">Rp {{ number_format($sale->change, 0, ',', '.') }}</span></div>
    </div>

    <div class="footer">
        <p>Terima kasih atas kunjungannya!</p>
        <p>Silakan datang kembali.</p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
        <p><small>Printed from POS Laravel System</small></p>
    </div>
</body>
</html>