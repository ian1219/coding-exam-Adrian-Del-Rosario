<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // CRUD API endpoint for USERS

    public function index(): JsonResponse
    {
        return response()->json(User::with('role')->get());
    }

    public function show($id): JsonResponse
    {
        $user = find_user_or_fail($id)->load('role');

        return response()->json($user);
    }

    public function store(UserCreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data)->load('role');

        $role = $user->role;
        if ($role) {
            $role->is_active = false;
            $role->save();
        }

        return success_response('User created successfully', $user, 201);
    }

    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        $user = find_user_or_fail($id);

        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        $user->load('role');

        return success_response('User Updated successfully', $user, 200);
    }

    public function destroy($id): JsonResponse
    {
        $user = find_user_or_fail($id);

        $user->delete();
        return success_response('User Deleted successfully', null, 200);
    }
}
