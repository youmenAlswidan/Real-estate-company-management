@extends('layouts')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Property Type Details</h4>
            </div>
            <div class="card-body">
                <p><strong>Property Type Name:</strong> {{ $property_type->name }}</p>
                <p><strong>Creation Date:</strong> {{ $property_type->created_at->format('Y-m-d') }}</p>
                <a href="{{ route('admin.property_types.index') }}" class="btn btn-secondary mt-3">Back</a>
            </div>
        </div>
    </div>
@endsection