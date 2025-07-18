@extends('admin.layouts')

@section('content')

    <div class="container mt-4">
        <h1>Edit Property Type Name</h1>

        <form action="{{ route('admin.property_types.update', $property_type->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Property Type Name:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $property_type->name) }}"
                    required
                    class="form-control"
                />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.property_types.index') }}" class="btn btn-secondary ms-2">Back to List</a>
        </form>
    </div>

@endsection