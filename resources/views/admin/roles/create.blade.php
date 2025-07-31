@extends('layouts')

@section('content')
    <h2>Create New Role</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" id="name" name="name" placeholder="Enter role name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Create Role</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
