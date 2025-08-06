<?php

namespace App\Services\Admin;

use App\Models\Property;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class PropertyService
{
    /**
     * Get all properties with optional filters.
     *
     * This method retrieves a collection of properties, optionally filtered by type ID and status.
     * It also loads related models: type, images, and services.
     *
     * @param array $filters Optional filters:
     *                       - 'type_id' (int): Filter by property type ID.
     *                       - 'status'  (string|int): Filter by property status.
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of Property models.
     */
    public function getAll($filters = [])
    {
        $query = Property::query()->with(['type', 'images', 'services']);

        if (!empty($filters['type_id'])) {
            $query->where('type_id', $filters['type_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    /**
     * Store a new property along with its services and images.
     *
     * This method creates a new property record using the provided data,
     * attaches the selected services, and uploads the associated images.
     *
     * @param array $data     The main property data to be stored in the database.
     * @param array $services Optional array of service IDs to be attached to the property.
     * @param array $images   Optional array of images to be uploaded and linked to the property.
     *
     * @return \App\Models\Property The newly created Property instance.
     */
    public function store(array $data, array $services = [], $images = [])
    {
        $property = Property::create($data);

        // ربط الخدمات
        $property->services()->sync($services);

        // رفع الصور
        $this->uploadImages($property, $images);

        return $property;
    }

    /**
     * Retrieve a property by its ID with its related type, images, and services.
     *
     * @param  int  $id  The ID of the property to retrieve.
     * @return \App\Models\Property
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the property is not found.
     */
    public function findById($id)
    {
        return Property::with(['type', 'images', 'services'])->findOrFail($id);
    }

    
    /**
     * Update the given property with provided data, services, and image modifications.
     *
     * This method performs the following:
     * - Updates property attributes.
     * - Syncs related services.
     * - Deletes selected images from storage and database.
     * - Replaces specified old images with new uploaded files.
     * - Uploads and attaches new images to the property.
     *
     * @param  \App\Models\Property  $property  The property model instance to update.
     * @param  array  $data  The attributes to update in the property.
     * @param  array  $services  (Optional) Array of service IDs to sync with the property.
     * @param  array  $imagesToDelete  (Optional) Array of image IDs to delete.
     * @param  array  $replaceImages  (Optional) Associative array of [image_id => UploadedFile] to replace old images.
     * @param  array  $newImages  (Optional) Array of UploadedFile instances to add as new images.
     *
     * @return \App\Models\Property  The updated property instance.
     */
    public function update(Property $property, array $data, array $services = [], $imagesToDelete = [], $replaceImages = [], $newImages = [])
    {
        $property->update($data);

        $property->services()->sync($services);

        // حذف الصور المحددة
        foreach ($imagesToDelete as $imageId) {
            $image = $property->images()->where('id', $imageId)->first();
            if ($image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        // استبدال الصور القديمة
        foreach ($replaceImages as $imageId => $newImageFile) {
            $oldImage = Image::find($imageId);
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
                $path = $newImageFile->store('properties', 'public');
                $oldImage->update(['image_path' => $path]);
            }
        }

        // رفع صور جديدة
        $this->uploadImages($property, $newImages);

        return $property;
    }

    /**
     * Delete the given property along with its associated images.
     *
     * This method performs the following:
     * - Deletes each image file from storage.
     * - Deletes image records from the database.
     * - Deletes the property record itself.
     *
     * @param  \App\Models\Property  $property  The property instance to delete.
     *
     * @return void
     */
    public function delete(Property $property)
    {
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $property->delete();
    }

    /**
     * Delete a single image from storage and database.
     *
     * This method:
     * - Deletes the image file from the 'public' disk.
     * - Deletes the image record from the database.
     *
     * @param  \App\Models\Image  $image  The image instance to delete.
     *
     * @return void
     */
    public function deleteImage(Image $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
    }

       /**
     * Upload and attach images to the given property.
     *
     * This method:
     * - Stores each uploaded image file in the 'public/properties' directory.
     * - Creates a corresponding image record in the database linked to the property.
     *
     * @param  \App\Models\Property  $property  The property to which the images will be attached.
     * @param  array<int, \Illuminate\Http\UploadedFile>  $images  An array of uploaded image files.
     *
     * @return void
     */
    private function uploadImages(Property $property, $images)
    {
        if (!$images) return;

        foreach ($images as $imageFile) {
            $path = $imageFile->store('properties', 'public');
            Image::create([
                'property_id' => $property->id,
                'image_path' => $path,
            ]);
        }
    }
}
