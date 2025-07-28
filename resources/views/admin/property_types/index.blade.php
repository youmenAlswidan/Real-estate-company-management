@extends('admin.layouts')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
      
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.property_types.store') }}">
        @csrf
        <div class="mt-2">
            <label for="name">Property Type Name</label>
            <input type="text" id="name" name="name" placeholder="Enter property type" required class="form-control">

            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button class="btn btn-success btn-sm mt-3" type="submit">Add</button>
    </form>
    
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h4>Property Types</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th width="250px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($property_types as $property_type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $property_type->name }}</td>
                                <td>
                                    <a href="{{ route('admin.property_types.show', $property_type->id) }}" class="btn btn-primary btn-sm mb-1">Show</a>
                                    <a href="{{ route('admin.property_types.edit', $property_type->id) }}" class="btn btn-info btn-sm mb-1">Edit</a>
                                        
                                    <form class="d-inline" method="POST" action="{{ route('admin.property_types.destroy', $property_type->id) }}" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm mb-1" type="submit">Delete</button>
                                    </form>
                                   
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>  
            </div>    
        </div>    
    </div>

@endsection