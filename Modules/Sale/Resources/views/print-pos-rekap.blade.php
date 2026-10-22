<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Penjualan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 10px;
        }

        .table-laporan {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table-laporan th,
        .table-laporan td {
            border: 1px solid #000;
            padding: 4px 5px;
            text-align: center;
            height: 16px;
        }

        .table-laporan thead th {
            background-color: #01349b;
            color: white;
            font-weight: bold;
            height: 22px;
            font-size: 12px;
        }

        .table-laporan .col-no {
            width: 8%;
        }

        .table-laporan .col-nama {
            width: 25%;
        }

        .table-laporan .col-total {
            width: 26%;
        }

        .table-laporan .col-pembayaran {
            width: 41%;
        }

        .table-laporan .nama {
            text-transform: uppercase;
        }

        .table-laporan .nominal {
            font-weight: bold;
        }

        /* Baris yang ditandai merah */
        .table-laporan .merah td {
            color: red;
        }

        .table-laporan tfoot td {
            background-color: #002060;
            color: white;
            font-weight: bold;
            height: 30px;
            font-size: 12px;
        }

        .table-laporan tfoot .label-total {
            text-align: center;
        }

        .table-laporan tfoot .nominal-total {
            white-space: nowrap;
        }

        .judul-laporan {
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            line-height: 1.5;
            margin-bottom: 6px;
            color: #000;
        }
    </style>
</head>

<body>

    <div class="judul-laporan">
        <div>TOTAL BELANJA IBU-IBU DWP UPT PPD PONOROGO</div>
        <div>BULAN {{ strtoupper(
            \Carbon\Carbon::createFromDate($tahun, $bulan, 1)
                ->locale('id')
                ->translatedFormat('F Y')
        ) }}</div>
    </div>

    <table class="table-laporan">
        <thead>
            <tr>
                <th class="col-no">NO</th>
                <th class="col-nama">NAMA</th>
                <th class="col-total">TOTAL</th>
                <th class="col-pembayaran">PEMBAYARAN</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($sales as $index => $sale)
                @php
                    $namaPelanggan = $sale->customer_name
                        ?? ($sale->customer->name ?? '-');
                @endphp
                
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td class="nama">
                        {{ $namaPelanggan }}
                    </td>

                    <td class="nominal">
                        {{ number_format($sale->total_rekap ?? 0, 0, ',', '.') }}
                    </td>

                    <td>
                        
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Data sales belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2" class="label-total">
                    TOTAL
                </td>

                <td class="nominal-total">
                    Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}
                </td>

                <td></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>