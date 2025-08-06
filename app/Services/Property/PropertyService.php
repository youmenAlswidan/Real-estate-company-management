<?php
namespace App\Services\Property;

use App\Traits\Property\ApiResponseTrait;
use App\Models\Property;
use App\Http\Resources\Property\PropertyResource;
use Illuminate\Http\JsonResponse;

class PropertyService
{
    use ApiResponseTrait;
    
    /**
     * Get a paginated list of properties with the latest first.
     *
     * @return JsonResponse
     */

   public function list(): JsonResponse
    {
        $query = Property::query();

        // Apply filter if type_id exists in the request
        if (request()->has('type_id')) {
            $query->where('type_id', request()->type_id);
        }

        // Use the filtered query for pagination
        $properties = $query->latest()->paginate(10);

        $resourceCollection = PropertyResource::collection($properties);
        return $this->successResponse($resourceCollection, 'Properties retrieved successfully.');
    }
    /**
     * Get the details of a single property.
     *
     * @param Property $property
     * @return JsonResponse
     */

    public function get(Property $property): JsonResponse
    {
        $resource = new PropertyResource($property);
        return $this->successResponse($resource, 'Property details retrieved successfully.');
    }
}
