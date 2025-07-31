<?php

namespace App\Services\Admin;

use App\Models\Service;
use Exception;
use Illuminate\Support\Facades\Log;

class PropertyServiceManager
{
    public function getAll()
    {
        try {
            return Service::all();
        } catch (Exception $e) {
            Log::error('Error fetching property services: ' . $e->getMessage());
            return collect(); // ترجع مجموعة فاضية لتجنب الكراش
        }
    }

    public function get(Service $service)
    {
        try {
            return $service;
        } catch (Exception $e) {
            Log::error('Error fetching single property service: ' . $e->getMessage());
            return null;
        }
    }

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
