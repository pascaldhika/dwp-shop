
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        h3 {
            text-align: center;
        }

        .periode {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #777;
            padding: 6px;
        }

        th {
            background: #eee;
            text-align: center;
        }

        .center {
            text-align: center;
        }

        .gambar {
            width: 55px;
            height: 55px;
        }
    </style>
</head>
<body>
    <h3>LAPORAN PENJUALAN PER PRODUK</h3>

    <div class="periode">
        Periode {{ \Carbon\Carbon::parse($start_date)
                    ->timezone('Asia/Jakarta')
                    ->locale('id')
                    ->translatedFormat('d F Y') }} s.d.
                {{ \Carbon\Carbon::parse($end_date)
                    ->timezone('Asia/Jakarta')
                    ->locale('id')
                    ->translatedFormat('d F Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td class="center">
                        @if ($sale->image_base64)
                            <img src="{{ $sale->image_base64 }}" class="gambar">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $sale->product_name }}</td>
                    <td class="center">
                        {{ number_format($sale->total_qty, 0, ',', '.') }}
                        {{ $sale->product_unit }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="center">
                        Tidak ada data penjualan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
