<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SalePayment;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitLossReport extends Component
{

    public $year;
    public $month;
    public $periode;
    public $sale_payments;

    protected $rules = [
        'year'      => 'required',
        'month'     => 'required'
    ];

    public function mount() {
        $this->year = '';
        $this->month = '';
        $this->periode = '';
        $this->sale_payments = 0;
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
    }
}
