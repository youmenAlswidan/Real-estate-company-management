<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Requests\PropertyService\StorePropertyServiceRequest;
use App\Http\Requests\PropertyService\UpdatePropertyServiceRequest;

class PropertyServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $property_services=Service::all();
        return view('admin.property_services.index',compact('property_services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyServiceRequest $request)
    {
        Service::create($request->validated());
        return redirect()->route('admin.property_services.index')->with('success','Property Service Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $property_service)
    {
        return view('admin.property_services.show',compact('property_service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $property_service)
    {
        return view('admin.property_services.edit',compact('property_service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyServiceRequest $request, Service $property_service)
    {
        $property_service->update($request->validated());
        return redirect()->route('admin.property_services.index')->with('success','Property Service Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $property_service)
    {
        $property_service->delete();
        return redirect()->route('admin.property_services.index')->with('success','Property Service deleted Successfully');
    }
}
