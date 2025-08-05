<div class="mb-3">
    <label for="name">Name:</label>
    <input type="text" name="name" value="{{ old('name', $property->name ?? '') }}" required class="form-control">
    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label for="location">Location:</label>
    <input type="text" name="location" value="{{ old('location', $property->location ?? '') }}" required class="form-control">
    @error('location') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label for="price">Price:</label>
    <input type="number" name="price" value="{{ old('price', $property->price ?? '') }}" required class="form-control">
    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label for="rooms">Rooms:</label>
    <input type="number" name="rooms" value="{{ old('rooms', $property->rooms ?? '') }}" required class="form-control">
    @error('rooms') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label for="area">Area:</label>
    <input type="number" step="0.01" name="area" value="{{ old('area', $property->area ?? '') }}" required class="form-control">
    @error('area') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label for="status">Status:</label>
    <select name="status" class="form-control" required>
        <option value="">Select Status</option>
        <option value="available" {{ old('status', $property->status ?? '') == 'available' ? 'selected' : '' }}>Available</option>
        <option value="sold" {{ old('status', $property->status ?? '') == 'sold' ? 'selected' : '' }}>Sold</option>
        <option value="rented" {{ old('status', $property->status ?? '') == 'rented' ? 'selected' : '' }}>Rented</option>
    </select>
    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label for="type_id">Property Type:</label>
    <select name="type_id" class="form-control" required>
        <option value="">Select Type</option>
        @foreach($types as $type)
            <option value="{{ $type->id }}" {{ old('type_id', $property->type_id ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
        @endforeach
    </select>
    @error('type_id') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label for="description">Description:</label>
    <textarea name="description" class="form-control">{{ old('description', $property->description ?? '') }}</textarea>
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
    <input type="text" name="visiting_hours" value="{{ old('visiting_hours', $property->visiting_hours ?? '') }}" required class="form-control">
    @error('visiting_hours') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label for="images">Images (you can upload multiple):</label>
    <input type="file" name="images[]" multiple class="form-control">
    @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror
</div>
