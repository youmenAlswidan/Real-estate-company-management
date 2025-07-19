@extends('admin.layouts')

@section('content')
    <h2>Edit Permissions for Role: {{ $role->name }}</h2>

    {{-- رسائل النجاح --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- رسالة الخطأ --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- أخطاء الفاليديشن --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.roles.updatePermissions', $role->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            @foreach ($permissions as $permission)
                @if ($permission->guard_name === $role->guard_name)
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input" id="perm{{ $permission->id }}"
                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                        <label class="form-check-label" for="perm{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endif
            @endforeach
        </div>

        <button type="submit" class="btn btn-success">Save Permissions</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
