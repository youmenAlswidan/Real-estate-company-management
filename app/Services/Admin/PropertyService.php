<?php

namespace App\Services\Admin;

use App\Models\Property;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class PropertyService
{
    /**
     * جلب جميع العقارات مع التصفية حسب النوع والحالة.
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
     * إنشاء عقار جديد مع ربط الخدمات وصور العقار.
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
     * جلب عقار مع العلاقات.
     */
    public function findById($id)
    {
        return Property::with(['type', 'images', 'services'])->findOrFail($id);
    }

    /**
     * تحديث بيانات العقار وربط الخدمات وصور العقار.
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
     * حذف عقار مع حذف الصور المرتبطة به.
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
     * حذف صورة واحدة.
     */
    public function deleteImage(Image $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
    }

    /**
     * رفع صور متعددة وربطها بالعقار.
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
