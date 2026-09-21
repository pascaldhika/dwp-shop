<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Katalog || {{ config('app.name') }}</title>
    <meta
      name="description"
      content="Browse the menu, build your order and check out — a responsive, mobile-first food ordering interface."
    />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=4">
  </head>
  <body>

    <!-- ===== Header ===== -->
    <header class="site-header">
        <div class="site-header__inner">

            <a href="#" class="logo_katalog">
                {{-- Logo DWP --}}
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo DWP"
                    class="logo__dwp"
                >

                <span class="logo__text">
                  Toko<span>Lestari</span>
                </span>
            </a>

            <div class="site-header__actions">

                {{-- Riwayat Transaksi --}}
                <a
                    class="cart-toggle"
                    href="{{ route('app.shop.history') }}"
                    aria-label="Riwayat transaksi"
                    title="Riwayat Transaksi"
                >
                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M3 3v5h5" />
                        <path d="M3.05 13a9 9 0 1 0 2.13-5.36L3 8" />
                        <path d="M12 7v5l3 2" />
                    </svg>
                </a>

                {{-- Keranjang --}}
                <button
                    class="cart-toggle"
                    id="cartToggle"
                    aria-label="Open cart"
                    aria-expanded="false"
                    aria-controls="cartDrawer"
                    title="Keranjang Belanja"
                >
                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>

                    <span class="cart-toggle__badge" id="cartCount">0</span>
                </button>

                {{-- Logout --}}
                <a
                    href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="cart-toggle"
                    id="logoutButton"
                    aria-label="Logout"
                    title="Keluar"
                >
                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                </a>

                <form
                    id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                    class="d-none"
                >
                    @csrf
                </form>

            </div>
        </div>
    </header>

    <!-- ===== Hero ===== -->
    <section class="hero">
        <div class="hero__content">
            <p class="hero__eyebrow">
                ✨ DWP UPT PPD Ponorogo
            </p>

            <h1 class="hero__title">
                Hai, {{ auth()->user()->name }}! 👋
                <br>
                <small class="hero__welcome"> Selamat datang di <span>Toko Lestari</span> </small>
            </h1>

            <p class="hero__sub">
                Belanja kebutuhan favoritmu dengan
                <strong>harga terbaik</strong>.
                Pilih produknya, masukkan ke keranjang,
                dan nikmati kemudahannya! 🛍️
            </p>

            <a href="#menu" class="btn btn--primary">
                Lihat Produk →
            </a>
        </div>
    </section>



    <!-- ===== Search + Category filter ===== -->
    <div class="menu-filter">

        <div class="search-box">
            <svg
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>

            <input
                type="search"
                id="productSearch"
                placeholder="Cari produk..."
                autocomplete="off"
            >

            <button
                type="button"
                id="clearSearch"
                class="search-box__clear"
                aria-label="Hapus pencarian"
                hidden
            >
                &times;
            </button>
        </div>

        <nav class="category-nav" id="categoryNav" aria-label="Menu categories">
            <button class="chip is-active" data-category="all">
                All
            </button>

            @foreach(\Modules\Product\Entities\Category::all() as $category)
                <button
                    class="chip"
                    data-category="{{ $category->category_name }}"
                >
                    {{ $category->category_name }}
                </button>
            @endforeach
        </nav>

    </div>

    <!-- ===== Menu ===== -->
    <main>
      <section class="menu" id="menu">
        <div class="menu__grid" id="menuGrid" aria-live="polite">
          <!-- menu cards injected by script.js -->
        </div>
      </section>
    </main>

    <!-- ===== Footer ===== -->
    @include('sale::partials.history-footer')

    <!-- ===== Sticky mobile order bar ===== -->
    <button class="order-bar" id="orderBar" hidden>
      <span id="orderBarCount">0 items</span>
      <span class="order-bar__divider">·</span>
      <span id="orderBarTotal">$0.00</span>
      <span class="order-bar__cta">Checkout →</span>
    </button>

    <!-- ===== Cart drawer (the "kitchen ticket") ===== -->
    <div class="cart-scrim" id="cartScrim"></div>
    <aside
      class="cart-drawer"
      id="cartDrawer"
      aria-label="Your order"
      aria-hidden="true"
    >
      <div class="ticket">
        <div class="ticket__head">
          <h2>Keranjang Belanja</h2>
          <button class="ticket__close" id="cartClose" aria-label="Close cart">
            &times;
          </button>
        </div>
        <p class="ticket__meta" id="ticketMeta">
          Ticket #— · <span id="ticketDate"></span>
        </p>

        <div class="ticket__items" id="cartItems">
          <!-- cart line items injected by script.js -->
        </div>

        <div class="ticket__empty" id="cartEmpty">
          <p>Keranjang belanja masih kosong.</p>
          <p class="ticket__empty-sub">Tambahkan produk dari Menu.</p>
        </div>

        <div class="ticket__divider" aria-hidden="true"></div>

        <div class="ticket__totals">
          <!-- <div class="ticket__row">
            <span>Subtotal</span>
            <span id="cartSubtotal">$0.00</span>
          </div> -->
          <div class="ticket__row ticket__row--total">
            <span>Total</span>
            <span id="cartTotal">$0.00</span>
          </div>
        </div>

        <p class="ticket__warning" id="ticketWarning">
          * Total transaksi belum memenuhi
        </p>

        <button class="btn btn--primary btn--block" id="checkoutBtn">
          Simpan
        </button>
      </div>
    </aside>

    <!-- ===== Toast ===== -->
    <div class="toast" id="toast" role="status" aria-live="polite"></div>

  </body>
</html>

@php
    $menuData = \Modules\Product\Entities\Product::with('category')
        ->get()
        ->map(function ($product) {
            $media = $product->getFirstMedia('images');

            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'category' => $product->category->category_name ?? '',
                'price' => (float) $product->product_price,
                'desc' => $product->product_note ?? '',
                'img' => $media
                    ? url('/media/' . str_replace('\\', '/', $media->getPathRelativeToRoot()))
                    : asset('images/no-image.png'),
            ];
        })
        ->values()
        ->toArray();

    $user = auth()->user();

    if (is_null($user->customer_id) || !$user->customer) {
      $minOrder = 0;
    } else{
      $minOrder = $user->customer->min_order;
    }
@endphp

<script>
    window.MENU = @json($menuData);
    window.SHOP_INDEX_URL = @json(route('app.shop.index'));
    window.SHOP_HISTORY_URL = @json(route('app.shop.history'));
    window.SHOP_STORE_URL = @json(route('app.shop.store'));
    window.MIN_ORDER = {!! $minOrder !!};
</script>

@if(session('buy_again_cart'))
<script>
    window.BUY_AGAIN_CART = @json(session('buy_again_cart'));
</script>
@endif

<script src="{{ asset('js/script.js') }}?v=2"></script>