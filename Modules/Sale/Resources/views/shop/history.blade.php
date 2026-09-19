@include('sale::partials.history-header')


<section class="hero history-hero">
    <div class="hero__content">
        
    </div>
</section>


<main class="history-page">

    <section class="menu history-menu">

        <div class="transaction-history">

            @forelse($transactions as $transaction)

                <article class="transaction-card">

                    <div class="transaction-card__header">

                        <div>
                            <p class="transaction-card__label">
                                Kode Transaksi
                            </p>

                            <h3 class="transaction-card__code">
                                {{ $transaction->reference }}
                            </h3>
                        </div>

                        <div class="transaction-card__date">
                            {{ $transaction->created_at->format('d M Y') }}<br>
                            {{ $transaction->created_at->format('H:i') }}
                        </div>

                    </div>


                    <div class="transaction-card__body">

                        <div>
                            <span>Total</span>

                            <strong>
                                Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>


                    <div class="transaction-card__footer">

                        <span>
                            {{ $transaction->saleDetails->sum('quantity') }} item
                        </span>

                        <div class="transaction-card__actions">

                            <a
                                href="{{ route('app.shop.history.detail', $transaction->id) }}"
                                class="btn btn--primary"
                            >
                                Lihat Detail
                            </a>

                            <a
                                href="{{ route('app.shop.beli-lagi', $transaction->id) }}"
                                class="btn btn--secondary"
                            >
                                Beli Lagi
                            </a>

                        </div>

                    </div>


                </article>

            @empty

                <div class="ticket__empty">
                    <p>Belum ada transaksi.</p>
                    <p class="ticket__empty-sub">
                        Transaksi yang sudah disimpan akan muncul di sini.
                    </p>
                </div>

            @endforelse

        </div>

    </section>

</main>

@include('sale::partials.history-footer')