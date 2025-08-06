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
    // Use trait for consistent success and error responses
    use ResponseTrait;

    // Service class instance to handle business logic related to property types
    protected $propertyTypeService;

    /**
     * Inject the PropertyTypeService dependency.
     *
     * @param PropertyTypeService $propertyTypeService
     */
    public function __construct(PropertyTypeService $propertyTypeService) {
        $this->propertyTypeService = $propertyTypeService;
    }

    /**
     * Display a list of all property types.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all property types through the service
        $property_types = $this->propertyTypeService->getAll();

        // Pass the property types to the index view
        return view('admin.property_types.index', compact('property_types'));
    }

    /**
     * Store a newly created property type.
     *
     * @param StorePropertyTypeRequest $request Validated request data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePropertyTypeRequest $request)
    {
        // Use the service to store the new property type
        $result = $this->propertyTypeService->store($request->validated());

        // Return appropriate response based on result
        if ($result) {
            return $this->successResponse('Property Type Added Successfully', 'admin.property_types.index');
        }
        return $this->errorResponse('Failed to Add Property Type', 'admin.property_types.index');
    }

    /**
     * Display the specified property type.
     *
     * @param PropertyType $property_type The property type model instance (Route Model Binding)
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(PropertyType $property_type)
    {
        // Get detailed property type information from service
        $property_type = $this->propertyTypeService->show($property_type);

        // If not found, return error response
        if(!$property_type) {
            return $this->errorResponse('Property Type not found', 'admin.property_types.index');
        }

        // Return view with the property type data
        return view('admin.property_types.show', ['property_type' => $property_type]);
    }

    /**
     * Show the form for editing the specified property type.
     *
     * @param PropertyType $property_type The property type model instance
     * @return \Illuminate\View\View
     */
    public function edit(PropertyType $property_type)
    {
        // Return the edit view with the property type data
        return view('admin.property_types.edit', compact('property_type'));
    }

    /**
     * Update the specified property type in storage.
     *
     * @param UpdatePropertyTypeRequest $request Validated update data
     * @param PropertyType $property_type The property type model instance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePropertyTypeRequest $request, PropertyType $property_type)
    {
        // Attempt to update the property type using the service
        $result = $this->propertyTypeService->update($property_type, $request->validated());

        // Return success or error response based on outcome
        if ($result) {
            return $this->successResponse('Property Type Updated Successfully', 'admin.property_types.index');
        }
        return $this->errorResponse('Failed to update Property Type', 'admin.property_types.index');
    }

    /**
     * Remove the specified property type from storage.
     *
     * @param PropertyType $property_type The property type model instance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PropertyType $property_type)
    {
        // Attempt to delete the property type via service
        $result = $this->propertyTypeService->delete($property_type);

        // Return success or error response accordingly
        if ($result) {
            return $this->successResponse('Property Type Deleted Successfully', 'admin.property_types.index');
        }
        return $this->errorResponse('Failed to delete Property Type', 'admin.property_types.index');
    }
}
