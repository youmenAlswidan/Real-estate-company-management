<?php

namespace App\Http\Controllers\API\Property;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\Property\PropertyService;


class PropertyController extends Controller
{

     public function __construct(private PropertyService $propertyService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->propertyService->list();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property = Property::findOrFail($id);
        return $this->propertyService->get($property);
    }

}
