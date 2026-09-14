@extends('layouts.app')

@section('title', 'Update Payroll')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payrolls.index') }}">Payrolls</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12">
                <livewire:search-employee/>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('utils.alerts')
                        <form id="payroll-form" action="{{ route('payrolls.update', $payroll) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-row">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{ $payroll->employee_id }}">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nik">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nik" id="nik" value="{{ $payroll->employee->nik }}" required readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nama">Nama <span class="text-danger">*</span></label>
                                        <input id="nama" type="text" class="form-control" name="nama" value="{{ $payroll->employee->nama }}" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="periode">Periode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="periode" value="{{ $payroll->periode }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="pph21">PPH 21 <span class="text-danger">*</span></label>
                                        <input id="pph21" type="text" class="form-control" name="pph21" value="{{ $payroll->pph21 }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="gaji_pokok">Gaji Pokok <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="gaji_pokok" type="text" class="form-control" name="gaji_pokok" value="{{ $payroll->gaji_pokok }}" required>
                                            <div class="input-group-append">
                                                <button id="getGajiPokok" class="btn btn-primary" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="tunjangan_jabatan">Tunjangan Jabatan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="tunjangan_jabatan" type="text" class="form-control" name="tunjangan_jabatan" value="{{ $payroll->tunjangan_jabatan }}" required>
                                            <div class="input-group-append">
                                                <button id="getTunjanganJabatan" class="btn btn-primary" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="tunjangan_konsumsi">Tunjangan Konsumsi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="tunjangan_konsumsi" type="text" class="form-control" name="tunjangan_konsumsi" value="{{ $payroll->tunjangan_konsumsi }}" required>
                                            <div class="input-group-append">
                                                <button id="getTunjanganKonsumsi" class="btn btn-primary" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="tunjangan_harian">Tunjangan Harian <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="tunjangan_harian" type="text" class="form-control" name="tunjangan_harian" value="{{ $payroll->tunjangan_harian }}" required>
                                            <div class="input-group-append">
                                                <button id="getTunjanganHarian" class="btn btn-primary" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="bonus_target">Bonus Target <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="bonus_target" type="text" class="form-control" name="bonus_target" value="{{ $payroll->bonus_target }}" required>
                                            <div class="input-group-append">
                                                <button id="getBonusTarget" class="btn btn-primary" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="asuransi">Asuransi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="asuransi" type="text" class="form-control" name="asuransi" value="{{ $payroll->asuransi }}" required>
                                            <div class="input-group-append">
                                                <button id="getAsuransi" class="btn btn-primary" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control">{{ $payroll->note }}</textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Update Payroll <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#gaji_pokok').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#tunjangan_jabatan').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#tunjangan_konsumsi').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#tunjangan_harian').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#bonus_target').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#asuransi').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            window.addEventListener('employeeSelected', (e) => {
                console.log(e.detail);

                var myStringArray = e.detail;
                var arrayLength = myStringArray.length;
                for (var i = 0; i < arrayLength; i++) {
                    $('#employee_id').val(myStringArray[i].id);
                    $('#nik').val(myStringArray[i].nik);
                    $('#nama').val(myStringArray[i].nama);
                }
            });

            $('#payroll-form').submit(function () {
                var gaji_pokok = $('#gaji_pokok').maskMoney('unmasked')[0];
                $('#gaji_pokok').val(gaji_pokok);

                var tunjangan_jabatan = $('#tunjangan_jabatan').maskMoney('unmasked')[0];
                $('#tunjangan_jabatan').val(tunjangan_jabatan);

                var tunjangan_konsumsi = $('#tunjangan_konsumsi').maskMoney('unmasked')[0];
                $('#tunjangan_konsumsi').val(tunjangan_konsumsi);

                var tunjangan_harian = $('#tunjangan_harian').maskMoney('unmasked')[0];
                $('#tunjangan_harian').val(tunjangan_harian);

                var bonus_target = $('#bonus_target').maskMoney('unmasked')[0];
                $('#bonus_target').val(bonus_target);
                
                var asuransi = $('#asuransi').maskMoney('unmasked')[0];
                $('#asuransi').val(asuransi);
            });
        });
    </script>
@endpush
