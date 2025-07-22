@extends('admin.layouts')

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

            @include('admin.properties.form')

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
