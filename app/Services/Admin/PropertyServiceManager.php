<?php

namespace App\Services\Admin;

use App\Models\Service;
use Exception;
use Illuminate\Support\Facades\Log;

class PropertyServiceManager
{

    /**
    * Get all service records.
    *
    * This method attempts to retrieve all records from the Service model.
    * If an exception occurs during the retrieval process, it logs the error
    * and returns an empty collection to prevent application crashes.
    *
    * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
    */
    public function getAll()
    {
        try {
            return Service::all();
        } catch (Exception $e) {
            Log::error('Error fetching property services: ' . $e->getMessage());
            return collect(); // ترجع مجموعة فاضية لتجنب الكراش
        }
    }


    /**
    * Retrieve a single service instance.
    *
    * This method returns the provided Service instance.
    * If an exception occurs, it logs the error and returns null.
    *
    * @param \App\Models\Service $service The service instance to retrieve.
    * @return \App\Models\Service|null
    */
    public function get(Service $service)
    {
        try {
            return $service;
        } catch (Exception $e) {
            Log::error('Error fetching single property service: ' . $e->getMessage());
            return null;
        }
    }

    /**
    * Store a new service record.
    *
    * Attempts to create a new Service using the provided data array.
    * Logs any exception that occurs during the process.
    *
    * @param array $data The data used to create the service record.
    * @return bool True if creation succeeds, false otherwise.
    */
    public function store(array $data): bool
    {
        try {
            Service::create($data);
            return true;
        } catch (Exception $e) {
            Log::error('Error creating property service: ' . $e->getMessage());
            return false;
        }
    }

    /**
    * Update an existing service record.
    *
    * Attempts to update the given Service instance with the provided data.
    * If an exception occurs during the update, it logs the error and returns false.
    *
    * @param \App\Models\Service $service The service instance to update.
    * @param array $data The data used to update the service record.
    * @return bool True if the update succeeds, false otherwise.
    */
    public function update(Service $service, array $data): bool
    {
        try {
            $service->update($data);
            return true;
        } catch (Exception $e) {
            Log::error('Error updating property service: ' . $e->getMessage());
            return false;
        }
    }

    /**
    * Delete an existing service record.
    *
    * Attempts to delete the given Service instance.
    * If an exception occurs during the deletion process, it logs the error and returns false.
    *
    * @param \App\Models\Service $service The service instance to delete.
    * @return bool True if the deletion succeeds, false otherwise.
    */
    public function destroy(Service $service): bool
    {
        try {
            $service->delete();
            return true;
        } catch (Exception $e) {
            Log::error('Error deleting property service: ' . $e->getMessage());
            return false;
        }
    }
}
