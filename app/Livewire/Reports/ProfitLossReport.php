<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Modules\Expense\Entities\Expense;
use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Entities\PurchasePayment;
use Modules\PurchasesReturn\Entities\PurchaseReturn;
use Modules\PurchasesReturn\Entities\PurchaseReturnPayment;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SalePayment;
use Modules\SalesReturn\Entities\SaleReturn;
use Modules\SalesReturn\Entities\SaleReturnPayment;
use Modules\Payroll\Entities\Payroll;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitLossReport extends Component
{

    public $year;
    public $month;
    public $periode;
    public $sale_payments;
    public $purchase_return_payments;
    public $purchase_payments;
    public $sale_return_payments;
    public $expenses_amount;
    public $payrolls_amount;

    protected $rules = [
        'year'      => 'required',
        'month'     => 'required'
    ];

    public function mount() {
        $this->year = '';
        $this->month = '';
        $this->periode = '';
        $this->sale_payments = 0;
        $this->purchase_return_payments = 0;
        $this->purchase_payments = 0;
        $this->sale_return_payments = 0;
        $this->expenses_amount = 0;
        $this->payrolls_amount = 0;
    }

    public function render() {
        $this->setValues();

        return view('livewire.reports.profit-loss-report');
    }

    public function generateReport() {
        $this->validate();
    }

    public function setValues() {
        $this->sale_payments = SalePayment::when($this->year, function ($query) {
            return $query->whereYear('date', '=', $this->year);
        })
        ->when($this->month, function ($query) {
            return $query->whereMonth('date', '=', $this->month);
        })
        ->sum('amount') / 100;

        $this->purchase_return_payments = PurchaseReturnPayment::when($this->year, function ($query) {
            return $query->whereYear('date', '=', $this->year);
        })
        ->when($this->month, function ($query) {
            return $query->whereMonth('date', '=', $this->month);
        })
        ->sum('amount') / 100;

        $this->purchase_payments = PurchasePayment::when($this->year, function ($query) {
            return $query->whereYear('date', '=', $this->year);
        })
        ->when($this->month, function ($query) {
            return $query->whereMonth('date', '=', $this->month);
        })
        ->sum('amount') / 100;

        $this->sale_return_payments = SaleReturnPayment::when($this->year, function ($query) {
            return $query->whereYear('date', '=', $this->year);
        })
        ->when($this->month, function ($query) {
            return $query->whereMonth('date', '=', $this->month);
        })
        ->sum('amount') / 100;

        $this->expenses_amount = Expense::when($this->year, function ($query) {
            return $query->whereYear('date', '=', $this->year);
        })
        ->when($this->month, function ($query) {
            return $query->whereMonth('date', '=', $this->month);
        })
        ->sum('amount') / 100;

        $this->periode = $this->year.$this->month;
        $this->payrolls_amount = Payroll::when($this->periode, function ($query) {
            return $query->where('periode', '=', $this->periode);
        })
        ->sum(\DB::raw('gaji_pokok + tunjangan_jabatan + tunjangan_konsumsi + tunjangan_harian + bonus_target - pph21 - asuransi'));
    }
}
