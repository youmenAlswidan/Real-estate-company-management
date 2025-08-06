@extends('layouts')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Employee Details</h4>
            </div>
            <div class="card-body">
                <p><strong>Employee Name:</strong> {{ $employee->name }}</p>
                <p><strong>Email:</strong> {{ $employee->email }}</p>
                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-success mt-3">Edit</a>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-danger mt-3">Back</a>
            </div>
        </div>
    </div>
@endsection
