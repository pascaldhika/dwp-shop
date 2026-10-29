
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
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Total</th>
                <th>Pelanggan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($sale->image_base64)
                            <img src="{{ $sale->image_base64 }}" class="gambar">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $sale->product_name }}</td>
                    <td class="text-end text-nowrap">{{ format_currency((($sale->purchase_price > 0) ? $sale->purchase_price : $sale->unit_price)) }}</td>
                    <td class="text-end text-nowrap">{{ format_currency($sale->unit_price) }}</td>
                    <td>
                        {{ number_format($sale->total_qty, 0, ',', '.') }}
                    </td>
                    <td>
                        <ol class="mb-0 ps-3">
                            @foreach (explode('|||', $sale->customer_names ?? '') as $customer)
                                @if (trim($customer) !== '')
                                    <li>
                                        {{ $customer }}
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="center">
                        Tidak ada data penjualan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
