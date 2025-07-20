@extends('admin.layouts')

@section('content')
    <h2>Create New Permission</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Permission Name</label>
            <input type="text" id="name" name="name" placeholder="Enter permission name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Create Permission</button>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
