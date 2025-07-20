<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\StorePropertyRequest;
use App\Http\Requests\Property\UpdatePropertyRequest;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('type', 'images')->get();
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $types = PropertyType::all();
        return view('admin.properties.create', compact('types'));
    }

    public function store(StorePropertyRequest $request)
    {
        $validated = $request->validated();

        $property = Property::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('properties', 'public');
                Image::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.properties.index')->with('success', 'Property added successfully.');
    }

    public function show($id)
    {
        $property = Property::with('type', 'images')->findOrFail($id);
        return view('admin.properties.show', compact('property'));
    }

    public function edit($id)
    {
        $property = Property::with('images')->findOrFail($id);
        $types = PropertyType::all();
        return view('admin.properties.edit', compact('property', 'types'));
    }

    public function update(UpdatePropertyRequest $request, $id)
    {
        $validated = $request->validated();

        $property = Property::findOrFail($id);
        $property->update($validated);

        if ($request->filled('images_to_delete')) {
            $imagesToDelete = explode(',', $request->input('images_to_delete'));
            foreach ($imagesToDelete as $imageId) {
                $image = $property->images()->where('id', $imageId)->first();
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }


        if ($request->hasFile('replace_images')) {
            foreach ($request->file('replace_images') as $imageId => $newImageFile) {
                $oldImage = Image::find($imageId);
                if ($oldImage) {

                    Storage::disk('public')->delete($oldImage->image_path);

                    $path = $newImageFile->store('properties', 'public');
                    $oldImage->update(['image_path' => $path]);
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('properties', 'public');
                Image::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.properties.index')->with('success', 'Property updated successfully.');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $property->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Property deleted successfully.');
    }

    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
