@extends('layouts')

@section('content')
    <h2>Roles</h2>

    @can('role.create')
        <a href="{{ route('admin.roles.create') }}" class="btn btn-success mb-2">Create Role</a>
    @endcan

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @can('role.view')
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
                            @can('role.edit')
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            @endcan

                            @can('role.permissions.edit')
                                <a href="{{ route('admin.roles.editPermissions', $role->id) }}" class="btn btn-warning btn-sm mx-1">Manage Permissions</a>
                            @endcan

                            @can('role.delete')
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You do not have permission to view roles.</p>
    @endcan
@endsection
