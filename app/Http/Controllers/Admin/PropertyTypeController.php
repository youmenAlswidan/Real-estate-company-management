<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use App\Http\Requests\PropertyType\StorePropertyTypeRequest;
use App\Http\Requests\PropertyType\UpdatePropertyTypeRequest;
use App\Services\Admin\PropertyTypeService;
use App\Traits\Admin\ResponseTrait;

class PropertyTypeController extends Controller
{
    use ResponseTrait;

    protected $propertyTypeService;

    public function __construct(PropertyTypeService $propertyTypeService) {
        $this->propertyTypeService = $propertyTypeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $property_types = $this->propertyTypeService->getAll();
        return view('admin.property_types.index', compact('property_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyTypeRequest $request)
    {
        $result=$this->propertyTypeService->store($request->validated());
        if ($result) {
            return $this->successResponse('Property Type Added Successfully', 'admin.property_types.index');
        }
        return $this->errorResponse('Failed to Add Property Type', 'admin.property_types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyType $property_type)
    {
        $property_type = $this->propertyTypeService->show($property_type);
        if(!$property_type) {
            return $this->errorResponse('Property Type not found', 'admin.property_types.index');
        }
        return view('admin.property_types.show', ['property_type' => $property_type]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyType $property_type)
    {
        return view('admin.property_types.edit', compact('property_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyTypeRequest $request, PropertyType $property_type)
    {
        $result = $this->propertyTypeService->update($property_type, $request->validated());
        if ($result) {
            return $this->successResponse('Property Type Updated Successfully', 'admin.property_types.index');
        }
        return $this->errorResponse('Failed to update Property Type', 'admin.property_types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyType $property_type)
    {
        $result = $this->propertyTypeService->delete($property_type);
        if ($result) {
            return $this->successResponse('Property Type Deleted Successfully', 'admin.property_types.index');
        }
        return $this->errorResponse('Failed to delete Property Type', 'admin.property_types.index');
    }
}
