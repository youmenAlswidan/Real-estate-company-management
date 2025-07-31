@extends('layouts')

@section('content')
<div class="container mt-4">
    <h2>Add New Property</h2>

    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf

        @include('admin.properties.form')

        <button type="submit" class="btn btn-success mt-2">Add Property</button>
        <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
@endsection
