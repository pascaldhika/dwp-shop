<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit="generateReport">
                        <div class="form-row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Year <span class="text-danger">*</span></label>
                                    <select wire:model="year" class="form-control" name="year">
                                        <option value="">Select Year</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Month <span class="text-danger">*</span></label>
                                    <select wire:model="month" class="form-control" name="month">
                                        <option value="">Select Month</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <i wire:target="generateReport" wire:loading.remove class="bi bi-shuffle"></i>
                                Filter Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <button onclick="exportTableToExcel('table-to-export', 'exported-table')" class="btn btn-success">
                        <i class="bi bi-file"></i>
                        Export Excel
                    </button>
                    <table id="table-to-export" class="table table-bordered table-striped text-center mb-0">
                        <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <thead>
                        <tr>
                            <th style="text-align: left;">No</th>
                            <th style="text-align: left;">#</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th colspan="3" style="text-align: left;">Income</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td style="text-align: left;">Sales Payments</td>
                                <td style="text-align: right;">{{ format_currency($sale_payments) }}</td>
                            </tr>
                            <tr>
                                @php
                                    $total_incomes = $sale_payments;
                                @endphp
                                <th style="text-align: right;" colspan="2">Total</th>
                                <th style="text-align: right;">{{ format_currency($total_incomes) }}</th>
                            </tr>
                            
                            <tr>
                                <th style="text-align: right;" colspan="2">Profit</th>
                                <th style="text-align: right;">{{ format_currency($total_incomes) }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
