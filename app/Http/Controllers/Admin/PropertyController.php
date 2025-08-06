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

    /**
     * Create a new instance of the controller with the given PropertyService.
     *
     * @param  \App\Services\Admin\PropertyService  $propertyService  The service responsible for property-related operations.
     */
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    /**
     * Display a listing of properties with optional filtering by type and status.
     *
     * This method:
     * - Retrieves all property types.
     * - Retrieves distinct property statuses.
     * - Applies filters based on request input (type and status).
     * - Fetches filtered properties using the PropertyService.
     * - Returns the view for listing properties in the admin panel.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request containing optional filters.
     *
     * @return \Illuminate\View\View
     */
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

    /**
     * Show the form for creating a new property.
     *
     * This method:
     * - Retrieves all available services.
     * - Retrieves all property types.
     * - Returns the view for the property creation form in the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $services = Service::all();
        $types = PropertyType::all();

        return view('admin.properties.create', compact('types', 'services'));
    }


    /**
     * Store a newly created property in storage.
     *
     * This method:
     * - Validates the incoming request data.
     * - Retrieves selected services and uploaded images from the request.
     * - Delegates the creation process to the PropertyService.
     * - Returns a success response with redirection.
     *
     * @param  \App\Http\Requests\Property\StorePropertyRequest  $request  The validated request containing property data.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePropertyRequest $request)
    {
        $validated = $request->validated();

        $services = $request->input('services', []);
        $images = $request->file('images', []);

        $this->propertyService->store($validated, $services, $images);

        return $this->successResponse('Property added successfully.', 'admin.properties.index');
    }

    /**
     * Display the specified property details.
     *
     * This method:
     * - Retrieves a property by its ID using the PropertyService.
     * - Returns the view to display the property's detailed information.
     *
     * @param  int  $id  The ID of the property to display.
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $property = $this->propertyService->findById($id);

        return view('admin.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified property.
     *
     * This method:
     * - Retrieves the property by its ID using the PropertyService.
     * - Retrieves all property types and available services.
     * - Returns the view for editing the property in the admin panel.
     *
     * @param  int  $id  The ID of the property to edit.
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $property = $this->propertyService->findById($id);
        $types = PropertyType::all();
        $services = Service::all();

        return view('admin.properties.edit', compact('property', 'types', 'services'));
    }


    /**
     * Update the specified property in storage.
     *
     * This method:
     * - Validates the incoming update request.
     * - Retrieves the target property by ID.
     * - Extracts selected services, images to delete, images to replace, and new uploaded images from the request.
     * - Delegates the update process to the PropertyService.
     * - Returns a success response with redirection.
     *
     * @param  \App\Http\Requests\Property\UpdatePropertyRequest  $request  The validated request containing updated property data.
     * @param  int  $id  The ID of the property to update.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Remove the specified property from storage.
     *
     * This method:
     * - Finds the property by its ID or fails if not found.
     * - Delegates the deletion process to the PropertyService, including image cleanup.
     * - Returns a success response with redirection.
     *
     * @param  int  $id  The ID of the property to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        $this->propertyService->delete($property);

        return $this->successResponse('Property deleted successfully.', 'admin.properties.index');
    }


    /**
     * Delete a specific image associated with a property.
     *
     * This method:
     * - Finds the image by its ID or fails if not found.
     * - Delegates the deletion process to the PropertyService (including file removal).
     * - Redirects back with a success message.
     *
     * @param  int  $id  The ID of the image to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);

        $this->propertyService->deleteImage($image);

        return back()->with('success', 'Image deleted successfully.');
    }
}
