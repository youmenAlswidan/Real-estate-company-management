<?php

namespace App\Services\Admin;
use App\Models\PropertyType;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Traits\Admin\PropertyTypeTrait;

class PropertyTypeService {
    use PropertyTypeTrait;

    public function getAll(){
        try{
        return PropertyType::all();
        } catch(Exception $e) {
            Log::error('Error fetching property types' . $e->getMessage());
            return collect();
        }
    }

    public function store( array $data) {
        try {
         PropertyType::create($data);
         return $this->successResponse('Property Type Added Successfully');
        } catch(Exception $e) {
            Log::error('Error storing property type' . $e->getMessage());
            return $this->errorResponse('Error storing property type');;
        }
    }

    public function show(PropertyType $property_type)
    {
       return $property_type;
    }

    public function update(PropertyType $property_type,array $data) {
        try{
         $property_type->update($data);
         return $this->successResponse('Property Type Updated Successfully');
        } catch(Exception $e) {
            Log::error('Error Updating property type' . $e->getMessage());
            return $this->errorResponse('Error Updating property type');;
        }

    }

    public function delete(PropertyType $property_type)
    {
        try {
         $property_type->delete();
         return $this->successResponse('Property Type deleted Successfully');
        } catch(Exception $e) {
            Log::error('Error deleting property type' . $e->getMessage());
            return $this->errorResponse('Error deleting property type');;
        }
    }
}