@extends('admin.layouts')

@section('content')

    <div class="container mt-4">
        <h4>Edit Property Service Name</h4>

        <form action="{{ route('admin.property_services.update', $property_service->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Property Service Name:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $property_service->name) }}"
                    required
                    class="form-control"
                />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.property_services.index') }}" class="btn btn-secondary ms-2">Back to List</a>
        </form>
    </div>

@endsection