
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
    <h3>LAPORAN PENJUALAN</h3>

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
                <th>Tanggal</th>
                <th>Nama</th>
                <th>List Belanja</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($sale->created_at)
                            ->timezone('Asia/Jakarta')
                            ->locale('id')
                            ->translatedFormat('d F Y H:i:s') }}
                    </td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>
                        <ol class="mb-0 ps-3">
                            @foreach ($sale->saleDetails as $detail)
                                <li>
                                    {{ $detail->product->product_name ?? 'Produk tidak ditemukan' }}
                                    ({{ number_format($detail->quantity, 0, ',', '.') }}
                                    {{ $detail->product->product_unit ?? '' }})
                                </li>
                            @endforeach
                        </ol>
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
