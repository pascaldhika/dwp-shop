<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 12px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #222;
        }

        .receipt {
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            text-align: center;
            padding-bottom: 8px;
            border-bottom: 1px dashed #777;
        }

        .company-name {
            margin: 0 0 4px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .company-info {
            margin: 0;
            font-size: 9px;
            line-height: 1.4;
        }

        /* =========================
           TRANSACTION INFO
        ========================= */

        .transaction-info {
            padding: 8px 0;
            border-bottom: 1px dashed #777;
        }

        .transaction-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .transaction-info td {
            padding: 2px 0;
            vertical-align: top;
        }

        .transaction-info .label {
            width: 100px;
            color: #555;
        }

        .transaction-info .separator {
            width: 10px;
            text-align: center;
        }

        .transaction-info .value {
            text-align: left;
            font-weight: 500;
        }

        /* =========================
           PRODUCT TABLE
        ========================= */

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .items th {
            padding: 5px 0;
            border-bottom: 1px solid #333;
            font-size: 10px;
        }

        .items td {
            padding: 6px 0;
            border-bottom: 1px dashed #ccc;
            vertical-align: top;
        }

        .product {
            width: 55%;
            text-align: left;
            padding-right: 8px !important;
        }

        .qty {
            width: 15%;
            text-align: center;
        }

        .price {
            width: 30%;
            text-align: right;
        }

        .product-name {
            font-weight: 500;
        }

        .product-detail {
            display: block;
            margin-top: 2px;
            font-size: 9px;
            color: #666;
        }

        /* =========================
           SUMMARY
        ========================= */

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .summary td,
        .summary th {
            padding: 4px 0;
        }

        .summary .label {
            text-align: left;
        }

        .summary .amount {
            text-align: right;
        }

        .grand-total {
            border-top: 1px solid #333;
            border-bottom: 1px double #333;
            font-size: 12px;
            font-weight: bold;
        }

        .grand-total td {
            padding: 7px 0;
        }

        /* =========================
           PAYMENT
        ========================= */

        .payment {
            width: 100%;
            border-collapse: collapse;
            margin-top: 7px;
        }

        .payment td {
            padding: 5px 0;
        }

        .payment .label {
            text-align: left;
        }

        .payment .amount {
            text-align: right;
            font-weight: bold;
        }

        /* =========================
           BARCODE
        ========================= */

        .barcode {
            text-align: center;
            padding-top: 10px;
        }

        .barcode svg {
            max-width: 100%;
            height: auto;
        }

        .reference {
            margin-top: 3px;
            font-size: 9px;
            text-align: center;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            margin-top: 10px;
            padding-top: 7px;
            border-top: 1px dashed #777;
            text-align: center;
            font-size: 9px;
            color: #555;
        }

        /* =========================
           PRINT
        ========================= */

        @media print {

            body {
                font-size: 11px;
            }

            .receipt {
                max-width: 100%;
            }

            .hidden-print {
                display: none !important;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

<div class="receipt">

    {{-- =========================
         HEADER
    ========================== --}}

    <div class="header">

        <h2 class="company-name">
            {{ settings()->company_name }}
        </h2>

        <p class="company-info">
            {{ settings()->company_email }}
            @if(settings()->company_email && settings()->company_phone)
                &nbsp;|&nbsp;
            @endif
            {{ settings()->company_phone }}

            @if(settings()->company_address)
                <br>
                {{ settings()->company_address }}
            @endif
        </p>

    </div>


    {{-- =========================
         TRANSACTION INFO
    ========================== --}}

    <div class="transaction-info">

        <table>
            <tr>
                <td class="label">Tanggal</td>
                <td class="separator">:</td>
                <td class="value">
                    {{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}
                </td>
            </tr>

            <tr>
                <td class="label">Kode Transaksi</td>
                <td class="separator">:</td>
                <td class="value">
                    {{ $sale->reference }}
                </td>
            </tr>

            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td class="value">
                    {{ $sale->customer_name }}
                </td>
            </tr>
        </table>

    </div>


    {{-- =========================
         ITEMS
    ========================== --}}

    <table class="items">

        <thead>
            <tr>
                <th class="product">Produk</th>
                <th class="qty">Qty</th>
                <th class="price">Jumlah</th>
            </tr>
        </thead>

        <tbody>

        @foreach($sale->saleDetails as $saleDetail)

            <tr>

                <td class="product">

                    <span class="product-name">
                        {{ $saleDetail->product->product_name }}
                    </span>

                    <span class="product-detail">
                        {{ format_currency($saleDetail->price) }}
                        / item
                    </span>

                </td>

                <td class="qty">
                    {{ $saleDetail->quantity }}
                </td>

                <td class="price">
                    {{ format_currency($saleDetail->sub_total) }}
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>


    {{-- =========================
         SUMMARY
    ========================== --}}

    <table class="summary">

        @if($sale->tax_percentage)

            <tr>
                <td class="label">
                    Tax ({{ $sale->tax_percentage }}%)
                </td>

                <td class="amount">
                    {{ format_currency($sale->tax_amount) }}
                </td>
            </tr>

        @endif


        @if($sale->discount_percentage)

            <tr>
                <td class="label">
                    Discount ({{ $sale->discount_percentage }}%)
                </td>

                <td class="amount">
                    -{{ format_currency($sale->discount_amount) }}
                </td>
            </tr>

        @endif


        @if($sale->shipping_amount)

            <tr>
                <td class="label">
                    Shipping
                </td>

                <td class="amount">
                    {{ format_currency($sale->shipping_amount) }}
                </td>
            </tr>

        @endif


        <tr class="grand-total">

            <td class="label">
                GRAND TOTAL
            </td>

            <td class="amount">
                {{ format_currency($sale->total_amount) }}
            </td>

        </tr>

    </table>

    {{-- =========================
         BARCODE
    ========================== --}}

    <!-- <div class="barcode">

        {!! \Milon\Barcode\Facades\DNS1DFacade::getBarcodeSVG($sale->reference, 'C128', 1, 25, 'black', false) !!}

        <div class="reference">
            {{ $sale->reference }}
        </div>

    </div> -->


    {{-- =========================
         FOOTER
    ========================== --}}

    <div class="footer">
        Terima kasih atas kunjungan Anda.
    </div>

</div>

</body>
</html>