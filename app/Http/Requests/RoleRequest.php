<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role_name'   => 'required|string|max:255|unique:roles,role_name,' . $this->id, // Allow unique role names except for the current role being updated
            'description' => 'nullable|string|max:255', // Description
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422)
        );
    }
}
