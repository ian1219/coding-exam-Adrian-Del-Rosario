<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    // CRUD API endpoint for ROLES

    public function index(): JsonResponse
    {
        return response()->json(Role::all());
    }

    public function show($id): JsonResponse
    {
        $role = find_role_or_fail($id);

        return response()->json($role);
    }

    public function publicIndex(): JsonResponse
    {
        $roles = Role::select('id', 'role_name')
            ->where('is_active', true)
            ->orderBy('role_name', 'asc')
            ->get();

        return response()->json($roles);
    }



    public function store(RoleRequest $request): JsonResponse
    {
        $role = Role::create($request->validated());

        return success_response('Role created successfully', $role, 201);
    }

    public function update(RoleRequest $request, $id): JsonResponse
    {
        $role = find_role_or_fail($id);

        $role->update($request->validated());

        return success_response('Role updated successfully', $role, 200);
    }

    public function destroy($id): JsonResponse
    {
        $role = find_role_or_fail($id);

        $role->delete();

        return success_response('Role deleted successfully', null, 200);
    }
}
