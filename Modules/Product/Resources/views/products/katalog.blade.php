<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Katalog | {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    
    @include('includes.main-css')
</head>

<body class="c-app flex-row align-items-center">
<div class="container">
    <div class="container-fluid">
        <div class="row margin-right: 10%; ">
            <!-- <div class="col-12">
                <input wire:model="search" type="text" class="form-control my-3" placeholder="Search Product...">
            </div> -->
            <div class="col-lg-12">
                <livewire:pos.product-list :categories="$product_categories"/>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>

@include('includes.main-js')
</body>
</html>
