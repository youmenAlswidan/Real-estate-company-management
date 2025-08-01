<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Http\Requests\PropertyType\StorePropertyTypeRequest;
use App\Http\Requests\PropertyType\UpdatePropertyTypeRequest;
use App\Services\Admin\PropertyTypeService;

class PropertyTypeController extends Controller
{
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
        return $this->propertyTypeService->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyType $property_type)
    {
        $property_type = $this->propertyTypeService->show($property_type);
        return view('admin.property_types.show', compact('property_type'));
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
        return $this->propertyTypeService->update($property_type, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyType $property_type)
    {
        return $this->propertyTypeService->delete($property_type);
    }
}
