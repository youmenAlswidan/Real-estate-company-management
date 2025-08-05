<?php
namespace App\Services\Admin;

use App\Models\PropertyType;
use Exception;
use Illuminate\Support\Facades\Log;

class PropertyTypeService
{

    /**
     * Retrieve all property types.
    *
    * This method attempts to fetch all records from the PropertyType model.
    * If an exception occurs, it logs the error and returns an empty collection.
    *
    * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
    */
    public function getAll()
    {
        try {
            return PropertyType::all();
        } catch (Exception $e) {
            Log::error('Error fetching property types: ' . $e->getMessage());
            return collect(); 
        }
    }


    /**
    * Store a new property type in the database.
    *
    * Attempts to create a new PropertyType record using the provided data array.
    * Logs any exception that occurs during the process.
     *
    * @param array $data The data used to create the property type.
    * @return bool Returns true on success, false if an exception occurs.
    */
    public function store(array $data)
    {
        try {
            PropertyType::create($data);
            return true;
        } catch (Exception $e) {
            Log::error('Error storing property type: ' . $e->getMessage());
            return false;
        }
    }

    /**
    * Retrieve a single property type instance.
    *
    * Returns the given PropertyType instance.
    * If an exception occurs, logs the error and returns null.
    *
    * @param \App\Models\PropertyType $property_type The property type instance to retrieve.
    * @return \App\Models\PropertyType|null
    */
    public function show(PropertyType $property_type)
    {
        try{
        return $property_type;
        } catch(Exception $e) {
            Log::error('Error fetching single property type: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update an existing property type with new data.
     *
     * Attempts to update the given PropertyType instance using the provided data array.
     * Logs any exceptions that occur during the update process.
     *
     * @param \App\Models\PropertyType $property_type The property type instance to update.
     * @param array $data The new data to apply to the property type.
     * @return bool Returns true on successful update, false if an exception occurs.
     */
    public function update(PropertyType $property_type, array $data)
    {
        try {
            $property_type->update($data);
            return true;
        } catch (Exception $e) {
            Log::error('Error updating property type: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a given property type from the database.
     *
     * Attempts to delete the specified PropertyType instance.
     * Logs any exceptions that occur during the deletion process.
     *
     * @param \App\Models\PropertyType $property_type The property type instance to delete.
     * @return bool Returns true on successful deletion, false if an exception occurs.
     */
    public function delete(PropertyType $property_type)
    {
        try {
            $property_type->delete();
            return true;
        } catch (Exception $e) {
            Log::error('Error deleting property type: ' . $e->getMessage());
            return false;
        }
    }
}
