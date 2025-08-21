<?php

use App\Models\Role;
use App\Models\User;

if (!function_exists('find_user_or_fail')) {
    function find_user_or_fail($id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404));
        }

        return $user;
    }
}

if (!function_exists('find_role_or_fail')) {
    function find_role_or_fail($id)
    {
        $role = Role::find($id);

        if (!$role) {
            abort(response()->json([
                'success' => false,
                'message' => 'Role not found'
            ], 404));
        }

        return $role;
    }
}

if (!function_exists('success_response')) {
    function success_response(string $message, $data = null, int $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}
