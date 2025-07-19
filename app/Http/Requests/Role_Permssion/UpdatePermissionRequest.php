<?php

namespace App\Http\Requests\role_permssion;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
        $permissionId = $this->route('permission')->id ?? null;

        return [
            'name' => 'required|unique:permissions,name,' . $permissionId,
        ];
    }
}
