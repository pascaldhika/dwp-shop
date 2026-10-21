<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Toko Lestari</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 2mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Calibri, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
        }

        /* HALAMAN */
        .nota-page {
            width: 100%;
            height: 276mm;
            page-break-after: always;
            overflow: hidden;
        }

        .nota-page:last-child {
            page-break-after: auto;
        }

        /* LAYOUT 2 KOLOM */
        .layout-nota {
            width: 100%;
            height: 276mm;
            /* border-collapse: collapse; */
            table-layout: fixed;
        }

        .layout-nota > tbody > tr {
            height: 92mm;
        }

        .layout-nota > tbody > tr > td {
            width: 50%;
            height: 92mm;
            padding: 2mm;
            vertical-align: top;
        }

        /* KOTAK NOTA */
        .nota {
            width: 100%;
            height: 72mm;
            padding: 1mm;
            border: 1px solid #000;
            overflow: hidden;
        }

        /* HEADER NOTA */
        .header-layout {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .header-layout td {
            padding: 0;
            vertical-align: top;
        }

        .judul-toko {
            padding-bottom: 2px !important;
        }

        .nama-toko {
            font-size: 20px;
            font-weight: bold;
            line-height: 1.1;
            white-space: nowrap;
        }

        .identitas-cell {
            width: 58%;
            font-size: 9px;
            font-weight: bold;
            line-height: 1.3;
            vertical-align: top;
        }

        .pelanggan-cell {
            width: 42%;
            font-size: 10px;
            line-height: 1.35;
            text-align: left;
            vertical-align: top;
        }

        .nama-pelanggan {
            font-weight: bold;
            overflow-wrap: break-word;
        }

        .garis-header {
            border: 0;
            border-top: 1px solid #000;
            margin: 3px 0 2px;
        }

        /* NOMOR NOTA */
        .nomor-nota {
            width: 100%;
            margin-bottom: 2px;
            border-collapse: collapse;
        }

        .nomor-nota td {
            padding: 1px 0;
            vertical-align: top;
        }

        .nomor-nota .label {
            width: 65px;
        }

        /* TABEL BARANG */
        .tabel-barang {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 9px;
        }

        .tabel-barang th,
        .tabel-barang td {
            padding: 2px 1px;
            border-bottom: 1px solid #ccc;
        }

        .tabel-barang th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            text-align: center;
            font-weight: bold;
        }

        .tabel-barang .kol-no {
            width: 5%;
            text-align: center;
        }

        .tabel-barang .kol-barang {
            width: 50%;
        }

        .tabel-barang .kol-jumlah {
            width: 10%;
            text-align: center;
        }

        .tabel-barang .kol-harga {
            width: 15%;
            text-align: right;
        }

        .tabel-barang .kol-total {
            width: 20%;
            text-align: right;
        }

        thead th {
            background: #002060;
            color: #fff;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            padding: 3px 1px;
            font-size: 8px;
            height: 21px;
            line-height: 1.05;
        }

        .angka {
            text-align: right;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        /* TOTAL */
        .total-layout {
            width: 100%;
            margin-top: 3px;
            border-collapse: collapse;
        }

        .total-layout td {
            padding: 2px 0;
            vertical-align: top;
        }

        .total-label {
            text-align: right;
            font-weight: bold;
        }

        .total-nominal {
            width: 30%;
            text-align: right;
            font-weight: bold;
            white-space: nowrap;
        }

        /* TANDA TANGAN */
        .footer-nota {
            width: 100%;
            margin-top: 7px;
            border-collapse: collapse;
        }

        .footer-nota td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 8px;
        }

        .ruang-ttd {
            height: 25px;
        }

        .nama-ttd {
            font-weight: bold;
            text-decoration: underline;
        }

        .catatan {
            margin-top: 5px;
            font-size: 7px;
            font-style: italic;
        }

        .tbody-barang td {
            border: 1px solid #000;
        }
    </style>
</head>

<body>

@php
    $daftarHalaman = $sales->values()->chunk(6);
@endphp

@foreach ($daftarHalaman as $halaman)

    <div class="nota-page">
        <table class="layout-nota">
            <tbody>

            @foreach ($halaman->chunk(2) as $baris)

                <tr>

                    @foreach ($baris as $sale)

                        @php
                            $tanggalNota = \Carbon\Carbon::parse($sale->date)
                                ->locale('id')
                                ->translatedFormat('d F Y');

                            $namaPelanggan = $sale->customer_name
                                ?? ($sale->customer->name ?? '-');
                        @endphp

                        <td>
                            <div class="nota">

                                {{-- HEADER --}}
                                <table class="header-layout">
                                    <tbody>

                                        {{-- Baris 1: Nama toko --}}
                                        <tr>
                                            <td colspan="2" class="judul-toko">
                                                <div class="nama-toko">
                                                    TOKO LESTARI
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Baris 2: Identitas dan tanggal --}}
                                        <tr>
                                            <td class="identitas-cell">
                                                DWP UPT PPD PONOROGO
                                                <br>
                                                JL. IR. H. JUANDA 39
                                                <br>
                                                PONOROGO
                                            </td>

                                            <td class="pelanggan-cell">
                                                Ponorogo, {{ $tanggalNota }}
                                                <br>
                                                Kepada Yth:
                                                <br>
                                                <span class="nama-pelanggan">
                                                    {{ $namaPelanggan }}
                                                </span>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                                <hr class="garis-header">

                                {{-- NOMOR NOTA --}}
                                <table class="nomor-nota">
                                    <tbody>
                                        <tr>
                                            <td class="label">Nota Nomor</td>
                                            <td>
                                                : {{ $sale->reference ?? $sale->id }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                {{-- DAFTAR BARANG --}}
                                <table class="tabel-barang">
                                    <thead>
                                        <tr>
                                            <th class="kol-no">No.</th>
                                            <th class="kol-barang">Nama Barang</th>
                                            <th class="kol-jumlah">Jumlah</th>
                                            <th>Harga Satuan</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>

                                    <tbody class="tbody-barang">
                                        @foreach ($sale->saleDetails as $index => $detail)
                                            <tr>
                                                <td class="kol-no">
                                                    {{ $index + 1 }}
                                                </td>

                                                <td class="kol-barang">
                                                    {{ $detail->product->product_name ?? 'Produk tidak ditemukan' }}
                                                </td>

                                                <td class="kol-jumlah">
                                                    {{ number_format((float) $detail->quantity, 0, ',', '.') }}
                                                </td>

                                                <td class="kol-harga angka">
                                                    {{ number_format((float) $detail->unit_price, 0, ',', '.') }}
                                                </td>

                                                <td class="kol-total angka">
                                                    {{ number_format(
                                                        $detail->sub_total,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- TOTAL --}}
                                <table class="total-layout">
                                    <tbody>
                                        <tr>
                                            <td class="total-label">
                                                TOTAL :
                                            </td>

                                            <td class="total-nominal">
                                                {{ number_format(
                                                    $sale->total_amount,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </td>

                    @endforeach

                    {{-- Jika jumlah nota ganjil, isi kolom kedua --}}
                    @if ($baris->count() === 1)
                        <td></td>
                    @endif

                </tr>

            @endforeach

            </tbody>
        </table>
    </div>

@endforeach

</body>
</html>