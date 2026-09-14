<?php

namespace Modules\Payroll\DataTables;

use Modules\Payroll\Entities\Payroll;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PayrollsDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('gaji_pokok', function ($data) {
                return format_currency($data->gaji_pokok);
            })
            ->addColumn('tunjangan_jabatan', function ($data) {
                return format_currency($data->tunjangan_jabatan);
            })
            ->addColumn('tunjangan_konsumsi', function ($data) {
                return format_currency($data->tunjangan_konsumsi);
            })
            ->addColumn('tunjangan_harian', function ($data) {
                return format_currency($data->tunjangan_harian);
            })
            ->addColumn('bonus_target', function ($data) {
                return format_currency($data->bonus_target);
            })
            ->addColumn('pph21', function ($data) {
                return format_currency($data->pph21);
            })
            ->addColumn('asuransi', function ($data) {
                return format_currency($data->asuransi);
            })
            ->addColumn('action', function ($data) {
                return view('payroll::partials.actions', compact('data'));
            });
    }

    public function query(Payroll $model) {
        return $model->newQuery();
    }

    public function html() {
        return $this->builder()
            ->setTableId('payrolls-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                'tr' .
                                <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(1)
            ->buttons(
                Button::make('excel')
                    ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('print')
                    ->text('<i class="bi bi-printer-fill"></i> Print'),
                Button::make('reset')
                    ->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')
                    ->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
    }

    protected function getColumns() {
        return [
            Column::make('periode')
            ->title('Periode')
                ->className('text-center align-middle'),

            Column::computed('gaji_pokok')
                ->className('text-center align-middle'),

            Column::computed('tunjangan_jabatan')
                ->className('text-center align-middle'),

            Column::computed('tunjangan_konsumsi')
                ->className('text-center align-middle'),

            Column::computed('tunjangan_harian')
                ->className('text-center align-middle'),

            Column::computed('bonus_target')
                ->className('text-center align-middle'),

            Column::computed('pph21')
                ->title('PPH 21')
                ->className('text-center align-middle'),

            Column::computed('asuransi')
                ->className('text-center align-middle'),

            Column::make('note')
                ->title('Note')
                ->className('text-center align-middle'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->className('text-center align-middle'),

            Column::make('created_at')
                ->visible(false)
        ];
    }

    protected function filename(): string {
        return 'Payroll_' . date('YmdHis');
    }
}
