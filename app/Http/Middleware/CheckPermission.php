<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permissionCode): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $permission = Permission::where('code', $permissionCode)->first();

        if (!$permission) {
            return response()->json(['message' => 'Permission not found'], 500);
        }

        $hasPermission = RolePermission::where('permission_id', $permission->id)
            ->where('role', $user->role)
            ->exists();

        if (!$hasPermission) {
            return response()->json(['message' => 'Forbidden — insufficient permissions'], 403);
        }

        return $next($request);
    }
}