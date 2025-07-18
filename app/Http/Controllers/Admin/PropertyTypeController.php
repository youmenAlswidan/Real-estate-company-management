<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Http\Requests\PropertyType\StorePropertyTypeRequest;
use App\Http\Requests\PropertyType\UpdatePropertyTypeRequest;

class PropertyTypeController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $property_types=PropertyType::all();
        return view('admin.property_types.index',compact('property_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyTypeRequest $request)
    {
        PropertyType::create($request->validated());
        return redirect()->route('admin.property_types.index')->with('success','Property Type Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyType $property_type)
    {
        return view('admin.property_types.show',compact('property_type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $property_type=PropertyType::findOrFail($id);
        return view('admin.property_types.edit',compact('property_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyTypeRequest $request, PropertyType $property_type)
    {           
        $property_type->update($request->validated());
        return redirect()->route('admin.property_types.index')->with('success','Property Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyType $property_type)
    {
        $property_type->delete();
        return redirect()->route('admin.property_types.index')->with('success','Property Type deleted Successfully');
    }
}
