<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\PropertyService\StorePropertyServiceRequest;
use App\Http\Requests\PropertyService\UpdatePropertyServiceRequest;
use App\Services\Admin\PropertyServiceManager;
use App\Traits\Admin\ResponseTrait;

class PropertyServiceController extends Controller
{
    use ResponseTrait;

    protected $serviceManager;

    public function __construct(PropertyServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $property_services = $this->serviceManager->getAll();
        return view('admin.property_services.index', compact('property_services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyServiceRequest $request)
    {
        $result = $this->serviceManager->store($request->validated());

        if ($result) {
            return $this->successResponse('Property Service Added Successfully', 'admin.property_services.index');
        }

        return $this->errorResponse('Failed to Add Property Service', 'admin.property_services.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $property_service)
    {
        $service = $this->serviceManager->get($property_service);

        if (!$service) {
            return $this->errorResponse('Property Service not found', 'admin.property_services.index');
        }

        return view('admin.property_services.show', ['property_service' => $service]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $property_service)
    {
        return view('admin.property_services.edit', compact('property_service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyServiceRequest $request, Service $property_service)
    {
        $result = $this->serviceManager->update($property_service, $request->validated());

        if ($result) {
            return $this->successResponse('Property Service Updated Successfully', 'admin.property_services.index');
        }

        return $this->errorResponse('Failed to Update Property Service', 'admin.property_services.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $property_service)
    {
        $result = $this->serviceManager->destroy($property_service);

        if ($result) {
            return $this->successResponse('Property Service deleted Successfully', 'admin.property_services.index');
        }

        return $this->errorResponse('Failed to Delete Property Service', 'admin.property_services.index');
    }
}
