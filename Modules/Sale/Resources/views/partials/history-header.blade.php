<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Riwayat Transaksi || {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="{{ asset('css/style-history.css') }}?v=3">
</head>

<body>

<header class="site-header">
    <div class="site-header__inner">

        <a href="{{ route('app.shop.index') }}" class="logo">
            Toko<span>Lestari</span>
        </a>

        <div class="site-header__actions">

            <a
                class="cart-toggle"
                href="{{ route('app.shop.index') }}"
                aria-label="Kembali ke katalog"
                title="Kembali ke Katalog"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="22"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M19 12H5"></path>
                    <path d="M12 19l-7-7 7-7"></path>
                </svg>
            </a>

        </div>

    </div>
</header>

<section class="hero history-hero">
    <div class="hero__content">
        
    </div>
</section>