<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255|unique:permissions,name,' . $this->id,
            'description' => 'nullable|string|max:255',
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
