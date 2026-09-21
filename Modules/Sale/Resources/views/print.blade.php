<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 25px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            background: #fff;
        }

        .page {
            width: 100%;
        }

        /* =========================
           HEADER
        ========================== */

        .header {
            width: 100%;
            padding-bottom: 18px;
            border-bottom: 2px solid #333;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-logo {
            width: 55%;
            vertical-align: middle;
        }

        .header-invoice {
            width: 45%;
            text-align: right;
            vertical-align: middle;
        }

        .logo {
            max-width: 180px;
            max-height: 70px;
        }

        .invoice-title {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .invoice-number {
            margin-top: 5px;
            font-size: 11px;
            color: #555;
        }

        /* =========================
           INFORMATION
        ========================== */

        .info {
            width: 100%;
            margin-top: 22px;
            border-collapse: collapse;
        }

        .info-box {
            width: 33.33%;
            vertical-align: top;
            padding-right: 18px;
        }

        .info-box:last-child {
            padding-right: 0;
        }

        .info-title {
            margin: 0 0 8px 0;
            padding-bottom: 7px;
            border-bottom: 1px solid #ccc;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .info-content {
            font-size: 10px;
            line-height: 1.6;
        }

        .info-content strong {
            font-size: 11px;
        }

        .info-row {
            margin-bottom: 3px;
        }

        /* =========================
           STATUS
        ========================== */

        .status {
            display: inline-block;
            padding: 3px 8px;
            margin-top: 2px;
            border: 1px solid #bbb;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        /* =========================
           PRODUCT TABLE
        ========================== */

        .items-wrapper {
            margin-top: 30px;
        }

        .section-title {
            margin: 0 0 10px 0;
            font-size: 12px;
            font-weight: bold;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
        }

        .items thead th {
            padding: 9px 7px;
            background: #f2f2f2;
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            font-size: 10px;
            font-weight: bold;
            text-align: left;
        }

        .items tbody td {
            padding: 9px 7px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
            font-size: 10px;
        }

        .items .product {
            width: 35%;
        }

        .items .unit-price {
            width: 17%;
            text-align: right;
        }

        .items .quantity {
            width: 10%;
            text-align: center;
        }

        .items .discount {
            width: 12%;
            text-align: right;
        }

        .items .tax {
            width: 12%;
            text-align: right;
        }

        .items .subtotal {
            width: 18%;
            text-align: right;
        }

        .product-name {
            font-weight: bold;
            font-size: 10px;
        }

        .product-code {
            margin-top: 3px;
            font-size: 8px;
            color: #666;
        }

        /* =========================
           TOTAL
        ========================== */

        .summary-wrapper {
            width: 100%;
            margin-top: 18px;
        }

        .summary {
            width: 45%;
            margin-left: 55%;
            border-collapse: collapse;
        }

        .summary td {
            padding: 6px 0;
            border-bottom: 1px solid #eee;
            font-size: 10px;
        }

        .summary .label {
            text-align: left;
        }

        .summary .amount {
            text-align: right;
        }

        .summary .grand-total td {
            padding: 10px 0;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            font-size: 13px;
            font-weight: bold;
        }

        /* =========================
           FOOTER
        ========================== */

        .footer {
            margin-top: 35px;
            padding-top: 12px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 9px;
            color: #777;
        }

        .footer-company {
            font-weight: bold;
            color: #444;
        }

        /* =========================
           PRINT
        ========================== */

        tr {
            page-break-inside: avoid;
        }

        thead {
            display: table-header-group;
        }
    </style>
</head>

<body>

<div class="page">

    {{-- =========================
         HEADER
    ========================== --}}

    <div class="header">

        <table class="header-table">
            <tr>

                <td class="header-logo">
                    <img
                        class="logo"
                        src="{{ public_path('images/logo-dark.png') }}"
                        alt="Logo"
                    >
                </td>

                <td class="header-invoice">

                    <h1 class="invoice-title">
                        INVOICE
                    </h1>

                    <div class="invoice-number">
                        INV/{{ $sale->reference }}
                    </div>

                </td>

            </tr>
        </table>

    </div>


    {{-- =========================
         INFORMATION
    ========================== --}}

    <table class="info">
        <tr>

            {{-- COMPANY --}}

            <td class="info-box">

                <h3 class="info-title">
                    Company Information
                </h3>

                <div class="info-content">

                    <div class="info-row">
                        <strong>
                            {{ settings()->company_name }}
                        </strong>
                    </div>

                    <div class="info-row">
                        {{ settings()->company_address }}
                    </div>

                    <div class="info-row">
                        Email:
                        {{ settings()->company_email }}
                    </div>

                    <div class="info-row">
                        Phone:
                        {{ settings()->company_phone }}
                    </div>

                </div>

            </td>


            {{-- CUSTOMER --}}

            <td class="info-box">

                <h3 class="info-title">
                    Customer Information
                </h3>

                <div class="info-content">

                    <div class="info-row">
                        <strong>
                            {{ $customer->customer_name }}
                        </strong>
                    </div>

                    @if($customer->address)
                        <div class="info-row">
                            {{ $customer->address }}
                        </div>
                    @endif

                    @if($customer->customer_email)
                        <div class="info-row">
                            Email:
                            {{ $customer->customer_email }}
                        </div>
                    @endif

                    @if($customer->customer_phone)
                        <div class="info-row">
                            Phone:
                            {{ $customer->customer_phone }}
                        </div>
                    @endif

                </div>

            </td>


            {{-- INVOICE --}}

            <td class="info-box">

                <h3 class="info-title">
                    Invoice Information
                </h3>

                <div class="info-content">

                    <div class="info-row">
                        Invoice:
                        <strong>
                            INV/{{ $sale->reference }}
                        </strong>
                    </div>

                    <div class="info-row">
                        Date:
                        {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}
                    </div>

                    <div class="info-row">
                        Status:
                        <span class="status">
                            {{ $sale->status }}
                        </span>
                    </div>

                    <div class="info-row">
                        Payment:
                        <span class="status">
                            {{ $sale->payment_status }}
                        </span>
                    </div>

                </div>

            </td>

        </tr>
    </table>


    {{-- =========================
         PRODUCTS
    ========================== --}}

    <div class="items-wrapper">

        <h3 class="section-title">
            Detail Transaksi
        </h3>

        <table class="items">

            <thead>

            <tr>
                <th class="product">
                    Produk
                </th>

                <th class="unit-price">
                    Harga Satuan
                </th>

                <th class="quantity">
                    Kuantitas
                </th>

                <th class="discount">
                    Diskon
                </th>

                <th class="tax">
                    Pajak
                </th>

                <th class="subtotal">
                    Sub Total
                </th>
            </tr>

            </thead>

            <tbody>

            @foreach($sale->saleDetails as $item)

                <tr>

                    <td class="product">

                        <div class="product-name">
                            {{ $item->product_name }}
                        </div>

                        <div class="product-code">
                            Code: {{ $item->product_code }}
                        </div>

                    </td>

                    <td class="unit-price">
                        {{ format_currency($item->unit_price) }}
                    </td>

                    <td class="quantity">
                        {{ $item->quantity }}
                    </td>

                    <td class="discount">
                        {{ format_currency($item->product_discount_amount) }}
                    </td>

                    <td class="tax">
                        {{ format_currency($item->product_tax_amount) }}
                    </td>

                    <td class="subtotal">
                        {{ format_currency($item->sub_total) }}
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>


    {{-- =========================
         SUMMARY
    ========================== --}}

    <div class="summary-wrapper">

        <table class="summary">

            <tbody>

            @if($sale->discount_percentage)

                <tr>
                    <td class="label">
                        Discount
                        ({{ $sale->discount_percentage }}%)
                    </td>

                    <td class="amount">
                        {{ format_currency($sale->discount_amount) }}
                    </td>
                </tr>

            @endif


            @if($sale->tax_percentage)

                <tr>
                    <td class="label">
                        Tax
                        ({{ $sale->tax_percentage }}%)
                    </td>

                    <td class="amount">
                        {{ format_currency($sale->tax_amount) }}
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

            </tbody>

        </table>

    </div>


    {{-- =========================
         FOOTER
    ========================== --}}

    <div class="footer">

        <div class="footer-company">
            {{ settings()->company_name }}
        </div>

        <div>
            Terima kasih atas kunjungan Anda.
        </div>

        <div>
            &copy; {{ date('Y') }}
        </div>

    </div>

</div>

</body>
</html>