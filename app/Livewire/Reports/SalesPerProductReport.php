<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Sale\Entities\SaleDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\File;

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


    protected function getSalesQuery()
    {
        return SaleDetails::query()
            ->selectRaw('
                products.id AS product_id,
                products.product_code,
                products.product_name,
                products.product_unit,
                SUM(sale_details.quantity) AS total_qty,
                SUM(
                    sale_details.quantity * (sale_details.unit_price / 100)
                ) AS grand_total,
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        customers.customer_name,
                        " (",
                        customer_orders.customer_qty,
                        ")"
                    )
                    ORDER BY customers.customer_name ASC
                    SEPARATOR "|||"
                ) AS customer_names
            ')
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->joinSub(
                SaleDetails::query()
                    ->selectRaw('
                        sale_details.product_id,
                        sales.customer_id,
                        SUM(sale_details.quantity) AS customer_qty
                    ')
                    ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
                    ->whereDate('sales.date', '>=', $this->start_date)
                    ->whereDate('sales.date', '<=', $this->end_date)
                    ->when($this->customer_id, function ($query) {
                        $query->where('sales.customer_id', $this->customer_id);
                    })
                    ->groupBy('sale_details.product_id', 'sales.customer_id'),
                'customer_orders',
                function ($join) {
                    $join->on('customer_orders.product_id', '=', 'sale_details.product_id')
                        ->on('customer_orders.customer_id', '=', 'sales.customer_id');
                }
            )
            ->whereDate('sales.date', '>=', $this->start_date)
            ->whereDate('sales.date', '<=', $this->end_date)
            ->when($this->customer_id, function ($query) {
                $query->where('sales.customer_id', $this->customer_id);
            })
            ->groupBy(
                'products.id',
                'products.product_code',
                'products.product_name',
                'products.product_unit'
            )
            ->orderBy('products.product_name', 'asc');
    }


    public function render()
    {
        return view('livewire.reports.sales-per-product-report', [
            'sales' => $this->getSalesQuery()->paginate(50),
        ]);
    }

    public function generateReport()
    {
        $this->validate();

        $this->resetPage();
    }


    public function exportPdf()
    {
        $sales = $this->getSalesQuery()->get();

        // Ambil seluruh produk sekaligus agar tidak query per produk.
        $products = Product::with('media')
            ->whereIn('id', $sales->pluck('product_id'))
            ->get()
            ->keyBy('id');

        $sales->each(function ($sale) use ($products) {
            $media = $products->get($sale->product_id)?->getFirstMedia('images');

            $sale->image_base64 = null;

            if ($media && is_file($media->getPath())) {
                $path = $media->getPath();
                $mime = mime_content_type($path);

                if (in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
                    $sale->image_base64 = 'data:' . $mime . ';base64,' .
                        base64_encode(file_get_contents($path));
                }
            }
        });

        $pdf = Pdf::loadView('livewire.reports.sales-per-product-pdf', [
            'sales' => $sales,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan-penjualan-per-produk.pdf'
        );
    }

}