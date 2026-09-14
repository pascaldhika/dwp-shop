@extends('layouts.app')

@section('title', 'Edit Employee')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button class="btn btn-primary">Update Employee <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nik">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nik" required value="{{ $employee->nik }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nama">Employee Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama" required value="{{ $employee->nama }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="jabatan" required value="{{ $employee->jabatan }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="" selected>Select Status</option>
                                            <option {{ $employee->status == 'Karyawan Tetap' ? 'selected' : '' }} value="Karyawan Tetap">Karyawan Tetap</option>
                                            <option {{ $employee->status == 'Karyawan Kontrak' ? 'selected' : '' }} value="Karyawan Kontrak">Karyawan Kontrak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

