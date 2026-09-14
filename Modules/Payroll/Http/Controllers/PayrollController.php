<?php

namespace Modules\Payroll\Http\Controllers;

use Modules\Payroll\DataTables\PayrollsDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Payroll\Entities\Payroll;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(PayrollsDataTable $dataTable)
    {
        abort_if(Gate::denies('access_payrolls'), 403);

        return $dataTable->render('payroll::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_payrolls'), 403);

        return view('payroll::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('create_payrolls'), 403);

        Payroll::create([
            'periode'               => $request->periode,
            'employee_id'           => $request->employee_id,
            'gaji_pokok'            => $request->gaji_pokok,
            'tunjangan_jabatan'     => $request->tunjangan_jabatan,
            'tunjangan_konsumsi'    => $request->tunjangan_konsumsi,
            'tunjangan_harian'      => $request->tunjangan_harian,
            'bonus_target'          => $request->bonus_target,
            'pph21'                 => $request->pph21,
            'asuransi'              => $request->asuransi,
            'note'                  => $request->note,
        ]);

        toast('Payroll Created!', 'success');

        return redirect()->route('payrolls.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Payroll $payroll) {
        abort_if(Gate::denies('show_payrolls'), 403);

        return view('payroll::show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Payroll $payroll)
    {
        abort_if(Gate::denies('edit_payrolls'), 403);

        return view('payroll::edit', compact('payroll'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Payroll $payroll)
    {
        abort_if(Gate::denies('update_payrolls'), 403);

        $payroll->update([
            'periode'               => $request->periode,
            'employee_id'           => $request->employee_id,
            'gaji_pokok'            => $request->gaji_pokok,
            'tunjangan_jabatan'     => $request->tunjangan_jabatan,
            'tunjangan_konsumsi'    => $request->tunjangan_konsumsi,
            'tunjangan_harian'      => $request->tunjangan_harian,
            'bonus_target'          => $request->bonus_target,
            'pph21'                 => $request->pph21,
            'asuransi'              => $request->asuransi,
            'note'                  => $request->note,
        ]);

        toast('Payroll Updated!', 'info');

        return redirect()->route('payrolls.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Payroll $payroll)
    {
        abort_if(Gate::denies('delete_payrolls'), 403);

        $payroll->delete();

        toast('Payroll Deleted!', 'warning');

        return redirect()->route('payrolls.index');
    }
}
