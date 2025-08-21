<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Permission::all());
    }

    public function show($id): JsonResponse
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }

    public function store(PermissionRequest $request): JsonResponse
    {
        $permission = Permission::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Permission created', 'data' => $permission], 201);
    }

    public function update(PermissionRequest $request, $id): JsonResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Permission updated', 'data' => $permission]);
    }

    public function destroy($id): JsonResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json(['success' => true, 'message' => 'Permission deleted']);
    }
}
