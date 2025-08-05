@extends('layouts')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@can('property_service.create')
<form method="POST" action="{{ route('admin.property_services.store') }}">
    @csrf
    <div class="mt-2">
        <label for="name">Property Service Name</label>
        <input type="text" id="name" name="name" placeholder="Enter property Service" required class="form-control">

        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <button class="btn btn-success btn-sm mt-3" type="submit">Add</button>
</form>
@endcan

<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            <h4>Property Services</h4>
        </div>
        <div class="card-body">

            @can('property_service.view')
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th width="250px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($property_services as $property_service)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $property_service->name }}</td>
                            <td>
                                @can('property_service.show')
                                    <a href="{{ route('admin.property_services.show', $property_service->id) }}" class="btn btn-primary btn-sm mb-1">Show</a>
                                @endcan

                                @can('property_service.edit')
                                    <a href="{{ route('admin.property_services.edit', $property_service->id) }}" class="btn btn-info btn-sm mb-1">Edit</a>
                                @endcan

                                @can('property_service.delete')
                                    <form class="d-inline" method="POST" action="{{ route('admin.property_services.destroy', $property_service->id) }}" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm mb-1" type="submit">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p>You do not have permission to view property services.</p>
            @endcan
            
        </div>    
    </div>    
</div>
@endsection
