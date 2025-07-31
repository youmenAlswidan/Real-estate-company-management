<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\StorePropertyRequest;
use App\Http\Requests\Property\UpdatePropertyRequest;
use App\Models\Property;
use App\Models\Image;
use App\Models\PropertyType;
use App\Models\Service;
use App\Services\Admin\PropertyService;
use App\Traits\Admin\ResponseTrait;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    use ResponseTrait;

    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    public function index(Request $request)
    {
        $types = PropertyType::all();
        $statuses = Property::select('status')->distinct()->pluck('status');

        $filters = [
            'type_id' => $request->input('type_id'),
            'status' => $request->input('status'),
        ];

        $properties = $this->propertyService->getAll($filters);

        return view('admin.properties.index', compact('properties', 'types', 'statuses'));
    }

    public function create()
    {
        $services = Service::all();
        $types = PropertyType::all();

        return view('admin.properties.create', compact('types', 'services'));
    }

    public function store(StorePropertyRequest $request)
    {
        $validated = $request->validated();

        $services = $request->input('services', []);
        $images = $request->file('images', []);

        $this->propertyService->store($validated, $services, $images);

        return $this->successResponse('Property added successfully.', 'admin.properties.index');
    }

    public function show($id)
    {
        $property = $this->propertyService->findById($id);

        return view('admin.properties.show', compact('property'));
    }

    public function edit($id)
    {
        $property = $this->propertyService->findById($id);
        $types = PropertyType::all();
        $services = Service::all();

        return view('admin.properties.edit', compact('property', 'types', 'services'));
    }

    public function update(UpdatePropertyRequest $request, $id)
    {
        $validated = $request->validated();

        $property = Property::findOrFail($id);

        $services = $request->input('services', []);
        $imagesToDelete = $request->filled('images_to_delete') ? explode(',', $request->input('images_to_delete')) : [];
        $replaceImages = $request->file('replace_images', []);
        $newImages = $request->file('images', []);

        $this->propertyService->update($property, $validated, $services, $imagesToDelete, $replaceImages, $newImages);

        return $this->successResponse('Property updated successfully.', 'admin.properties.index');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        $this->propertyService->delete($property);

        return $this->successResponse('Property deleted successfully.', 'admin.properties.index');
    }

    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);

        $this->propertyService->deleteImage($image);

        return back()->with('success', 'Image deleted successfully.');
    }
}
