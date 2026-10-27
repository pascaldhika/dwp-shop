@extends('layouts.app')

@section('title', 'Home')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item active">Home</li>
    </ol>
@endsection

<style>
    /* Tabel peringkat */
    .ranking-table {
        width: 100%;
        font-size: 13px;
    }

    .ranking-table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 12px;
        vertical-align: middle;
        white-space: nowrap;
        padding: 12px 10px;
    }

    .ranking-table tbody td {
        padding: 10px;
        vertical-align: middle;
    }

    .ranking-table .rank-number {
        width: 50px;
    }

    .ranking-table .rank-orders {
        width: 90px;
    }

    .ranking-table .rank-total {
        min-width: 130px;
    }

    .ranking-table .customer-name {
        min-width: 120px;
        overflow-wrap: anywhere;
        white-space: normal;
    }

    /* Responsif untuk HP */
    @media (max-width: 767.98px) {
        .ranking-section > div {
            margin-bottom: 16px;
        }

        .ranking-section .card-header {
            padding: 12px !important;
        }

        .ranking-section .card-header h6 {
            font-size: 14px;
            line-height: 1.5;
        }

        .ranking-table {
            font-size: 12px;
        }

        .ranking-table thead th {
            font-size: 11px;
            padding: 10px 8px;
        }

        .ranking-table tbody td {
            padding: 9px 8px;
        }

        .ranking-table .rank-total {
            min-width: 115px;
        }

        .ranking-section .card-footer {
            padding: 10px 12px;
        }
    }
</style>

@section('content')
    <div class="container-fluid">
        @can('show_total_stats')
        <div class="row">
            <div class="col-md-3 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                            <i class="bi bi-bar-chart font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-primary">{{ format_currency($revenue) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">Total Pendapatan</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-info p-4 mfe-3 rounded-left">
                            <i class="bi bi-trophy font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-info">{{ format_currency($profit) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">Total Keuntungan</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                            <i class="bi bi-bar-chart font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-primary">{{ format_currency($monthly_revenue) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">Pendapatan Bulan Ini</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                            <i class="bi bi-trophy font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-info">{{ format_currency($monthly_profit) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">Keuntungan Bulan Ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <!-- @can('show_weekly_sales_purchases|show_month_overview')
        <div class="row mb-4">
            @can('show_weekly_sales_purchases')
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header">
                        Sales & Purchases of Last 7 Days
                    </div>
                    <div class="card-body">
                        <canvas id="salesPurchasesChart"></canvas>
                    </div>
                </div>
            </div>
            @endcan
            @can('show_month_overview')
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header">
                        Overview of {{ now()->format('F, Y') }}
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <div class="chart-container" style="position: relative; height:auto; width:280px">
                            <canvas id="currentMonthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
        </div>
        @endcan -->

        <!-- @can('show_monthly_cashflow')
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        Monthly Cash Flow (Payment Sent & Received)
                    </div>
                    <div class="card-body">
                        <canvas id="paymentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endcan -->

        {{-- Peringkat Pelanggan Bulan Ini --}}
        <div class="row mt-4 ranking-section">

            {{-- Pelanggan Sudah Memesan --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-success">
                            <i class="bi bi-trophy-fill mr-2"></i>
                            Pelanggan Sudah Pesan
                        </h6>

                        <small class="text-muted">
                            Periode {{ now()->translatedFormat('F Y') }}
                        </small>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 ranking-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center rank-number">No.</th>
                                        <th>Nama Pelanggan</th>
                                        <th class="text-center rank-orders">Pesanan</th>
                                        <th class="text-right rank-total">Total Transaksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($customersOrdered as $customer)
                                        <tr>
                                            <td class="text-center align-middle">
                                                @if ($loop->iteration == 1)
                                                    <span class="badge badge-success">
                                                        1
                                                    </span>
                                                @elseif ($loop->iteration == 2)
                                                    <span class="badge badge-secondary">
                                                        2
                                                    </span>
                                                @elseif ($loop->iteration == 3)
                                                    <span class="badge badge-warning">
                                                        3
                                                    </span>
                                                @else
                                                    {{ $loop->iteration }}
                                                @endif
                                            </td>

                                            <td class="align-middle">
                                                {{ $customer->customer_name }}
                                            </td>

                                            <td class="text-center align-middle">
                                                <span class="badge badge-info">
                                                    {{ $customer->orders_count }} kali
                                                </span>
                                            </td>

                                            <td class="text-right align-middle">
                                                {{ format_currency(($customer->monthly_total ?? 0) / 100) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                Belum ada pelanggan yang memesan bulan ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white">
                        <small class="text-muted">
                            Total pelanggan sudah memesan:
                            <strong>{{ $customersOrdered->count() }}</strong>
                        </small>
                    </div>

                </div>
            </div>


            {{-- Pelanggan Belum Memesan --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-danger">
                            <i class="bi bi-person-x-fill mr-2"></i>
                            Pelanggan Belum Pesan
                        </h6>

                        <small class="text-muted">
                            Periode {{ now()->translatedFormat('F Y') }}
                        </small>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 ranking-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center rank-number">No.</th>
                                        <th>Nama Pelanggan</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($customersNotOrdered as $customer)
                                        <tr>
                                            <td class="text-center align-middle">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="align-middle">
                                                {{ $customer->customer_name }}
                                            </td>

                                            <td class="text-center align-middle">
                                                <span class="badge badge-danger">
                                                    Belum Pesan
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-success">
                                                <i class="bi bi-check-circle-fill mr-1"></i>
                                                Semua pelanggan sudah memesan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white">
                        <small class="text-muted">
                            Total pelanggan belum memesan:
                            <strong>{{ $customersNotOrdered->count() }}</strong>
                        </small>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('third_party_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
            integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@push('page_scripts')
    @vite('resources/js/chart-config.js')
@endpush
