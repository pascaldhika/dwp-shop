<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Sale\Entities\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $customers;
    public $start_date;
    public $end_date;
    public $customer_id;
    public $sale_status;
    public $payment_status;

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    public function mount($customers) {
        $this->customers = $customers;
       
        // Tanggal 1 bulan ini
        $this->start_date = today()
            ->startOfMonth()
            ->format('Y-m-d');

        // Tanggal terakhir bulan ini
        $this->end_date = today()
            ->endOfMonth()
            ->format('Y-m-d');
            
        $this->customer_id = '';
        $this->sale_status = '';
        $this->payment_status = '';
    }


    protected function getSalesQuery()
    {
        return Sale::with(['saleDetails.product'])
            ->whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date)
            ->when($this->customer_id, function ($query) {
                return $query->where('customer_id', $this->customer_id);
            })
            ->when($this->sale_status, function ($query) {
                return $query->where('status', $this->sale_status);
            })
            ->when($this->payment_status, function ($query) {
                return $query->where('payment_status', $this->payment_status);
            })
            ->orderBy('date', 'desc');
    }

    
    public function render()
    {
        return view('livewire.reports.sales-report', [
            'sales' => $this->getSalesQuery()->paginate(10),
        ]);
    }


    public function generateReport() {
        $this->validate();
        $this->render();
    }

    public function exportPdf()
    {
        $sales = $this->getSalesQuery()->get();

        $pdf = Pdf::loadView('livewire.reports.sales-pdf', [
            'sales' => $sales,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan-penjualan.pdf'
        );
    }
}
