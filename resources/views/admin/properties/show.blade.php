@extends('admin.layouts')

@section('content')
<div class="container mt-4">
    <h2>Property Details</h2>

    <div class="card p-3">
        <p><strong>Name:</strong> {{ $property->name }}</p>
        <p><strong>Location:</strong> {{ $property->location }}</p>
        <p><strong>Price:</strong> {{ $property->price }}</p>
        <p><strong>Rooms:</strong> {{ $property->rooms }}</p>
        <p><strong>Area:</strong> {{ $property->area }}</p>
        <p><strong>Status:</strong> {{ ucfirst($property->status) }}</p>
        <p><strong>Type:</strong> {{ $property->type->name ?? '-' }}</p>
        <p><strong>Description:</strong> {{ $property->description ?? '-' }}</p>
        @if($property->services->count())
        <p><strong>Additional Services:</strong>
            @foreach($property->services as $service)
                {{$service->name}},
                @endforeach
                @else <p>There is no Additional Services</p>
                @endif
        <p><strong>Created At:</strong> {{ $property->created_at->format('Y-m-d') }}</p>

        <h5>Images:</h5>
        <div class="d-flex flex-wrap">
            @foreach($property->images as $image)
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Property Image" width="150" class="m-2 rounded border">
            @endforeach
        </div>

        <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
@endsection
