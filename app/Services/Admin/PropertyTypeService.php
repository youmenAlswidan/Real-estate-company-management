<?php
namespace App\Services\Admin;

use App\Models\PropertyType;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Traits\Admin\ResponseTrait;

class PropertyTypeService
{
    use ResponseTrait;

    public function getAll()
    {
        try {
            return PropertyType::all();
        } catch (Exception $e) {
            Log::error('Error fetching property types: ' . $e->getMessage());
            return collect(); // لا حاجة لرد redirect هنا لأنه مجرد جلب بيانات
        }
    }

    public function store(array $data)
    {
        try {
            PropertyType::create($data);
            return $this->successResponse('Property Type Added Successfully', 'admin.property_types.index');
        } catch (Exception $e) {
            Log::error('Error storing property type: ' . $e->getMessage());
            return $this->errorResponse('Error storing property type', 'admin.property_types.index');
        }
    }

    public function show(PropertyType $property_type)
    {
        return $property_type;
    }

    public function update(PropertyType $property_type, array $data)
    {
        try {
            $property_type->update($data);
            return $this->successResponse('Property Type Updated Successfully', 'admin.property_types.index');
        } catch (Exception $e) {
            Log::error('Error updating property type: ' . $e->getMessage());
            return $this->errorResponse('Error updating property type', 'admin.property_types.index');
        }
    }

    public function delete(PropertyType $property_type)
    {
        try {
            $property_type->delete();
            return $this->successResponse('Property Type deleted Successfully', 'admin.property_types.index');
        } catch (Exception $e) {
            Log::error('Error deleting property type: ' . $e->getMessage());
            return $this->errorResponse('Error deleting property type', 'admin.property_types.index');
        }
    }
}
