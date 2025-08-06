@extends('layouts')

@section('content')
<div class="container mt-4">
    <h2>Add New Property</h2>

    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf

        {{-- Copy of form fields --}}
        <div class="mb-3">
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="form-control">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="location">Location:</label>
            <input type="text" name="location" value="{{ old('location') }}" required class="form-control">
            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="price">Price:</label>
            <input type="number" name="price" value="{{ old('price') }}" required class="form-control">
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="rooms">Rooms:</label>
            <input type="number" name="rooms" value="{{ old('rooms') }}" required class="form-control">
            @error('rooms') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="area">Area:</label>
            <input type="number" step="0.01" name="area" value="{{ old('area') }}" required class="form-control">
            @error('area') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="status">Status:</label>
            <select name="status" class="form-control" required>
                <option value="">Select Status</option>
                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
            </select>
            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="type_id">Property Type:</label>
            <select name="type_id" class="form-control" required>
                <option value="">Select Type</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
            @error('type_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            @foreach ($services as $service)
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       name="services[]"
                       value="{{ $service->id }}"
                       id="service_{{ $service->id }}"
                       {{ (old('services') && in_array($service->id, old('services'))) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="service_{{ $service->id }}">
                    {{ $service->name }}
                </label>
            </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label for="visiting_hours">Visiting hours:</label>
            <input type="text" name="visiting_hours" value="{{ old('visiting_hours') }}" required class="form-control">
            @error('visiting_hours') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="images">Images (you can upload multiple):</label>
            <input type="file" name="images[]" multiple class="form-control">
            @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success mt-2">Add Property</button>
        <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
@endsection
