@extends('layouts')

@section('content')
<div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-3">Edit Property</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name">Name:</label>
                <input type="text" name="name" value="{{ old('name', $property->name) }}" required class="form-control">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="location">Location:</label>
                <input type="text" name="location" value="{{ old('location', $property->location) }}" required class="form-control">
                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="price">Price:</label>
                <input type="number" name="price" value="{{ old('price', $property->price) }}" required class="form-control">
                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="rooms">Rooms:</label>
                <input type="number" name="rooms" value="{{ old('rooms', $property->rooms) }}" required class="form-control">
                @error('rooms') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="area">Area:</label>
                <input type="number" step="0.01" name="area" value="{{ old('area', $property->area) }}" required class="form-control">
                @error('area') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="status">Status:</label>
                <select name="status" class="form-control" required>
                    <option value="">Select Status</option>
                    <option value="available" {{ old('status', $property->status) == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="sold" {{ old('status', $property->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                    <option value="rented" {{ old('status', $property->status) == 'rented' ? 'selected' : '' }}>Rented</option>
                </select>
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="type_id">Property Type:</label>
                <select name="type_id" class="form-control" required>
                    <option value="">Select Type</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ old('type_id', $property->type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('type_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control">{{ old('description', $property->description) }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                @foreach ($services as $service)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="services[]"
                           value="{{ $service->id }}"
                           id="service_{{ $service->id }}"

                           @if (old('services') && in_array($service->id, old('services')))
                               checked
                           @elseif (isset($property) && $property->services->contains($service->id))
                               checked
                           @endif
                    >
                    <label class="form-check-label" for="service_{{ $service->id }}">
                        {{ $service->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <div class="mb-3">
                <label for="visiting_hours">Visiting hours:</label>
                <input type="text" name="visiting_hours" value="{{ old('visiting_hours', $property->visiting_hours) }}" required class="form-control">
                @error('visiting_hours') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="images">Upload New Images:</label>
                <input type="file" name="images[]" multiple class="form-control">
                @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <h5 class="mt-4">Current Images:</h5>
            <div class="d-flex flex-wrap mb-4">
                @forelse($property->images as $image)
                    <div class="position-relative m-2" style="width: 140px; position: relative;">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Property Image" width="120" class="rounded border">

                        <button type="button"
                                class="btn btn-sm btn-danger"
                                style="position: absolute; top: 5px; right: 5px; padding: 0 6px; line-height: 1; font-size: 16px; border-radius: 50%;"
                                onclick="removeImage({{ $image->id }})"
                                aria-label="Delete Image"
                        >&times;</button>

                        <input type="file" name="replace_images[{{ $image->id }}]" class="form-control form-control-sm mt-1">
                    </div>
                @empty
                    <p class="text-muted">No images available for this property.</p>
                @endforelse
            </div>

            <input type="hidden" name="images_to_delete" id="images_to_delete" value="">

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary me-2">Back</a>
                <button type="submit" class="btn btn-primary">Update Property</button>
            </div>
        </form>
    </div>
</div>

<script>
    let imagesToDelete = [];

    function removeImage(id) {
        if(confirm('Are you sure you want to delete this image?')) {
            imagesToDelete.push(id);
            document.getElementById('images_to_delete').value = imagesToDelete.join(',');
            event.target.closest('div.position-relative').style.display = 'none';
        }
    }
</script>
@endsection
