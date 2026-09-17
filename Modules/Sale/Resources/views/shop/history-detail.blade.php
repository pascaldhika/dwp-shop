@include('sale::partials.history-header')

<main>

    <section class="menu">

        <div class="transaction-detail">

            <div class="ticket">

                <div class="ticket__head">

                    <div>

                        <h2>
                            {{ $transaction->reference }}
                        </h2>

                        <p class="ticket__meta">

                            {{ $transaction->created_at->format('d F Y') }}

                            ·

                            {{ $transaction->created_at->format('H:i') }}

                        </p>

                    </div>

                </div>


                <div class="ticket__items">

                    @foreach($transaction->saleDetails as $item)

                        <div class="ticket-item">

                            <div>

                                <p class="ticket-item__name">
                                    {{ $item->product->product_name }}
                                </p>

                                <div class="ticket-item__line">

                                    <span>
                                        {{ $item->quantity }}
                                        ×
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </span>

                                </div>

                            </div>

                            <span class="ticket-item__price">

                                Rp{{ number_format(
                                    $item->quantity * $item->price,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </span>

                        </div>

                    @endforeach

                </div>


                <div
                    class="ticket__divider"
                    aria-hidden="true"
                ></div>


                <div class="ticket__totals">

                    <div class="ticket__row ticket__row--total">

                        <span>
                            Total
                        </span>

                        <span>
                            Rp{{ number_format(
                                $transaction->total_amount,
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>

                    </div>

                </div>


                <a
                    href="{{ route('app.shop.history') }}"
                    class="btn btn--primary btn--block"
                >
                    Kembali ke Riwayat
                </a>

            </div>

        </div>

    </section>

</main>


@include('sale::partials.history-footer')