<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Sale\Entities\SaleDetails;

class SalesPerProductReport extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $customers;
    public $start_date;
    public $end_date;
    public $customer_id;

    protected $rules = [
        'start_date' => 'required|date|before_or_equal:end_date',
        'end_date'   => 'required|date|after_or_equal:start_date',
    ];

    public function mount($customers)
    {
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
    }


    public function render()
    {
        $sales = SaleDetails::query()
            ->selectRaw('
                products.product_code, 
                products.product_name, 
                SUM(sale_details.quantity) AS total_qty, 
                SUM( sale_details.quantity * (sale_details.unit_price / 100) ) AS grand_total 
            ') 
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id') 
            ->join('products', 'products.id', '=', 'sale_details.product_id') 
            ->whereDate('sales.date', '>=', $this->start_date) 
            ->whereDate('sales.date', '<=', $this->end_date) 
            ->when($this->customer_id, function ($query) { 
                $query->where('sales.customer_id', $this->customer_id); 
            }) 
            ->groupBy('products.product_code', 'products.product_name') 
            ->orderBy('products.product_name', 'asc') 
            ->paginate(10);

        return view('livewire.reports.sales-per-product-report', [
            'sales' => $sales
        ]);
    }

    public function generateReport()
    {
        $this->validate();

        $this->resetPage();
    }
}