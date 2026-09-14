<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slip Gaji</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div style="text-align: center;margin-bottom: 25px;">
                <img width="180" src="{{ public_path('images/logo-dark.png') }}" alt="Logo">
                <h4 style="margin-bottom: 20px;">
                    <div><strong>{{ settings()->company_name }}</strong></div>
                    <div>{{ settings()->company_address }}</div>
                    <hr>
                    <div><strong>SLIP GAJI KARYAWAN</strong></div>
                    <div><strong>Periode {{ \Carbon\Carbon::parse($payroll->periode . '01')->firstOfMonth()->format('d M Y') }} - {{ \Carbon\Carbon::parse($payroll->periode . '01')->lastOfMonth()->format('d M Y') }}</strong></div>
                </h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-xs-4 mb-3 mb-md-0">
                            <div>NIK: <strong>{{ $employee->nik }}</strong></div>
                            <div>Nama: <strong>{{ $employee->nama }}</strong></div>
                            <div>Jabatan: <strong>{{ $employee->jabatan }}</strong></div>
                            <div>Status: <strong>{{ $employee->status }}</strong></div>
                        </div>
                    </div>

                    <div class="table-responsive-sm" style="margin-top: 30px;">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="align-middle" colspan="3">PENGHASILAN</th>
                                <th class="align-middle" colspan="3">POTONGAN</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">Gaji Pokok</td>
                                    <td class="text-right">=</td>
                                    <td class="text-right">{{ format_currency($payroll->gaji_pokok) }}</td>

                                    <td class="align-middle">PPH 21</td>
                                    <td class="text-right">=</td>
                                    <td class="text-right">{{ format_currency($payroll->pph21) }}</td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Tj. Jabatan</td>
                                    <td class="text-right">=</td>
                                    <td class="text-right">{{ format_currency($payroll->tunjangan_jabatan) }}</td>

                                    <td class="align-middle">Asuransi</td>
                                    <td class="text-right">=</td>
                                    <td class="text-right">{{ format_currency($payroll->asuransi) }}</td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Tj. Konsumsi</td>
                                    <td class="text-right">=</td>
                                    <td class="text-right">{{ format_currency($payroll->tunjangan_konsumsi) }}</td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Tj. Harian</td>
                                    <td class="text-right">=</td>
                                    <td class="text-right">{{ format_currency($payroll->tunjangan_harian) }}</td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Bonus Target</td>
                                    <td class="text-right">=</td>
                                    <td class="text-right">{{ format_currency($payroll->bonus_target) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <?php
                                    $total_penghasilan = $payroll->gaji_pokok+$payroll->tunjangan_jabatan+$payroll->tunjangan_konsumsi+$payroll->tunjangan_harian+$payroll->bonus_target;
                                    $total_potongan = $payroll->pph21+$payroll->asuransi;
                                ?>
                                <tr>
                                    <th class="text-right" colspan="3">{{ format_currency($total_penghasilan) }}</th>
                                    <th class="text-right" colspan="3">{{ format_currency($total_potongan) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="row mb-4">
                        <div style="text-align: center;margin-bottom: 25px;">
                            <h4 style="margin-bottom: 20px;">
                                <div><strong>PENERIMAAN BERSIH (A-B) = {{ format_currency($total_penghasilan-$total_potongan) }}</strong></div>
                            </h4>
                            <div>Terbilang: # {{ \Modules\Payroll\Entities\Payroll::penyebut($total_penghasilan-$total_potongan) }} rupiah #</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div style="text-align: right;margin-bottom: 25px;">
                            <div>Jakarta, {{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                            <div>Manager Operasional</div>
                            <br><br><br>
                            <div><strong>Dinda Cermat, SE.</strong></div>
                        </div>
                    </div>
                    
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-xs-12">
                            <p style="font-style: italic;text-align: center">{{ settings()->company_name }} &copy; {{ date('Y') }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
