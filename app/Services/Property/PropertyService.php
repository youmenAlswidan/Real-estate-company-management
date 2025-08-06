<?php
namespace App\Services\Property;

use App\Traits\Property\ApiResponseTrait;
use App\Models\Property;
use App\Http\Resources\Property\PropertyResource;
use Illuminate\Http\JsonResponse;

class PropertyService
{
    use ApiResponseTrait;

    public function list(): JsonResponse
    {
        $properties = Property::latest()->paginate(10);
        $resourceCollection = PropertyResource::collection($properties);
        return $this->successResponse($resourceCollection, 'Properties retrieved successfully.');
    }

    public function get(Property $property): JsonResponse
    {
        $resource = new PropertyResource($property);
        return $this->successResponse($resource, 'Property details retrieved successfully.');
    }
}
