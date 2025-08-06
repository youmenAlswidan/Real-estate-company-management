@extends('admin.layouts')

@section('content')
    <h2>Edit Employee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Employee Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $employee->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Employee Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Employee Email" value="{{ old('email', $employee->email) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Employee Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Employee Password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Employee</button>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
