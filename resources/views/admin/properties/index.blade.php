@extends('layouts')

@section('content')
<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Properties</h2>
        <a href="{{ route('admin.properties.create') }}" class="btn btn-success btn-sm">Add New Property</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Location</th>
                <th>Price</th>
                <th>Status</th>
                <th>Type</th>
                <th>Services</th>
                <th>Visiting Hours</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($properties as $property)
            <tr>
                <td>
                    @if($property->images->first())
                        <img src="{{ asset('storage/' . $property->images->first()->image_path) }}" width="70" class="rounded border">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ $property->name }}</td>
                <td>{{ $property->location }}</td>
                <td>{{ $property->price }}</td>
                <td>{{ ucfirst($property->status) }}</td>
                <td>{{ $property->type->name ?? '-' }}</td>
                <td>
                    @if($property->services->count())
                    @foreach($property->services as $service)
                    <p>{{$service->name}}</p>
                    @endforeach
                    @else <p>No Additional Services</p>
                    @endif
                </td>
                <td>{{ $property->visiting_hours }}</td>
                <td>
                    <a href="{{ route('admin.properties.show', $property->id) }}" class="btn btn-primary btn-sm mb-1">Show</a>
                    <a href="{{ route('admin.properties.edit', $property->id) }}" class="btn btn-info btn-sm mb-1">Edit</a>
                    <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm mb-1">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
