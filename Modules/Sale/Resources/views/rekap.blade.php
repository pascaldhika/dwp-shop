@extends('layouts.app')

@section('title', 'Sales')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Sales</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form id="sale-form" action="{{ route('sales.pos.rekap-pdf') }}" method="GET">
                        <div class="form-row">
                            {{-- Filter Tahun --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Tahun <span class="text-danger">*</span></label>

                                    <select name="tahun" class="form-control" required>
                                        @for ($year = date('Y'); $year >= date('Y') - 5; $year--)
                                            <option value="{{ $year }}"
                                                {{ request('tahun', date('Y')) == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            {{-- Filter Bulan --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Bulan <span class="text-danger">*</span></label>

                                    <select name="bulan" class="form-control" required>
                                        @foreach ([
                                            1 => 'Januari',
                                            2 => 'Februari',
                                            3 => 'Maret',
                                            4 => 'April',
                                            5 => 'Mei',
                                            6 => 'Juni',
                                            7 => 'Juli',
                                            8 => 'Agustus',
                                            9 => 'September',
                                            10 => 'Oktober',
                                            11 => 'November',
                                            12 => 'Desember'
                                        ] as $nomor => $namaBulan)
                                            <option value="{{ $nomor }}"
                                                {{ request('bulan', date('n')) == $nomor ? 'selected' : '' }}>
                                                {{ $namaBulan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-shuffle"></i>
                                Cetak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection