<?php

namespace Modules\Employee\Http\Controllers;

use Modules\Employee\DataTables\EmployeesDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Employee\Entities\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(EmployeesDataTable $dataTable) {
        abort_if(Gate::denies('access_employees'), 403);

        return $dataTable->render('employee::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_employees'), 403);

        return view('employee::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('create_employees'), 403);

        $request->validate([
            'nik'            => 'required|string|max:17',
            'nama'           => 'required|string|max:255',
            'jabatan'        => 'required|string|max:255',
            'status'         => 'required|string|max:20',
        ]);

        Employee::create([
            'nik'            => $request->nik,
            'nama'           => $request->nama,
            'jabatan'        => $request->jabatan,
            'status'         => $request->status,
        ]);

        toast('Employee Created!', 'success');

        return redirect()->route('employees.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Employee $employee) {
        abort_if(Gate::denies('show_employees'), 403);

        return view('employee::show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Employee $employee)
    {
        abort_if(Gate::denies('edit_employees'), 403);

        return view('employee::edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Employee $employee)
    {
        abort_if(Gate::denies('update_employees'), 403);

        $request->validate([
            'nik'            => 'required|string|max:17',
            'nama'           => 'required|string|max:255',
            'jabatan'        => 'required|string|max:255',
            'status'         => 'required|string|max:20',
        ]);

        $employee->update([
            'nik'            => $request->nik,
            'nama'           => $request->nama,
            'jabatan'        => $request->jabatan,
            'status'         => $request->status,
        ]);

        toast('Employee Updated!', 'info');

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Employee $employee) {
        abort_if(Gate::denies('delete_employees'), 403);

        $employee->delete();

        toast('Employee Deleted!', 'warning');

        return redirect()->route('employees.index');
    }
}
