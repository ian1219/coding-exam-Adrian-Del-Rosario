<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255|unique:users,full_name,' . $this->id, // Allow unique full names except for the current user being updated
            'email'     => 'required|email|max:255|unique:users,email,' . $this->id, // Allow unique emails except for the current user being updated
            'password'  => $this->isMethod('post')  // Password & Confirm Password
                ? 'required|confirmed|min:8'
                : 'sometimes|confirmed|min:8',
            'role_id'   => 'required|exists:roles,id|unique:users,role_id,' . $this->id, // Allow unique role_id except for the current user being updated
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
