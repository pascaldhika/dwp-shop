@extends('layouts.app')

@section('title', 'Laporan Penjualan Per Produk')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Laporan Penjualan Per Produk</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <livewire:reports.sales-per-product-report :customers="\Modules\People\Entities\Customer::all()"/>
    </div>
@endsection
