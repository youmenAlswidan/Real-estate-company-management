<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     public function rules(): array
    {
        return [
            'name' => 'required|string',
            'location' => 'required|string',
            'rooms' => 'required|integer',
            'area' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'required|in:available,sold,rented',
            'type_id' => 'required|exists:property_types,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'services' => 'sometimes|array',
            'services.*' => 'integer|exists:services,id',
            'visiting_hours' => 'required|string',
        ];
    }
}
