@extends('layouts')

@section('content')
    <h2>Create New Employee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Employee Name</label>
            <input type="text" id="name" name="name" placeholder="Enter Employee name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Employee Email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Employee password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Create Employee</button>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
