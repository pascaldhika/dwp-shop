<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {

    //Generate PDF
    Route::get('/payrolls/pdf/{id}', function ($id) {
        $payroll = \Modules\Payroll\Entities\Payroll::findOrFail($id);
        $employee = \Modules\Employee\Entities\Employee::findOrFail($payroll->employee_id);

        $pdf = \PDF::loadView('payroll::print', [
            'payroll' => $payroll,
            'employee' => $employee,
        ])->setPaper('a4');

        return $pdf->stream('payroll-'. $employee->nama .'.pdf');
    })->name('payrolls.pdf');

    Route::resource('payrolls', 'PayrollController');

});
