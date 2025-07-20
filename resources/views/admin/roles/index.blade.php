@extends('admin.layouts')

@section('content')
    <h2>Roles</h2>

    <a href="{{ route('admin.roles.create') }}" class="btn btn-success mb-2">Create Role</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Role Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary btn-sm">Edit</a>

                        <a href="{{ route('admin.roles.editPermissions', $role->id) }}" class="btn btn-warning btn-sm mx-1">Manage Permissions</a>

                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
