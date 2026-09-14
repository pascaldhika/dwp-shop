@extends('layouts.app')

@section('title', 'Payroll Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payrolls.index') }}">Payrolls</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Periode</th>
                                    <td>{{ $payroll->periode }}</td>
                                </tr>
                                <tr>
                                    <th>Gaji Pokok</th>
                                    <td>{{ $payroll->gaji_pokok }}</td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Jabatan</th>
                                    <td>{{ $payroll->tunjangan_jabatan }}</td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Konsumsi</th>
                                    <td>{{ $payroll->tunjangan_konsumsi }}</td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Harian</th>
                                    <td>{{ $payroll->tunjangan_harian }}</td>
                                </tr>
                                <tr>
                                    <th>Bonus Target</th>
                                    <td>{{ $payroll->bonus_target }}</td>
                                </tr>
                                <tr>
                                    <th>PPH 21</th>
                                    <td>{{ $payroll->pph21 }}</td>
                                </tr>
                                <tr>
                                    <th>Asuransi</th>
                                    <td>{{ $payroll->asuransi }}</td>
                                </tr>
                                <tr>
                                    <th>Note</th>
                                    <td>{{ $payroll->note }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

