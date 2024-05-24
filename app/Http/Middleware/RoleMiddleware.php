<?php

namespace App\Http\Middleware;

use App\Models\Permissions;
use App\Models\RolePermissions;
use App\Models\UserRoles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (Auth::check() && $user) {
            $userRole = UserRoles::where('id', $user->user_roles_id)->first();

            if (!in_array(strtolower(str_replace(' ', '', $userRole->role_name)), $roles)) {
                return redirect('/dashboard')->with('error', 'You do not have the necessary permissions to access that page.');
            }

            // Get the current route
            $currentRoute = Route::current();

            // Get the route name
            $routeName = $currentRoute->getName();

            $rolePermissions = RolePermissions::where('user_roles_id', $userRole->id)->get();

            $permisisonIds = [];

            foreach ($rolePermissions as $rolePermission) {
                $permisisonIds[] = $rolePermission->permissions_id;
            }

            $permissions = [];

            if ($permisisonIds) {
                $permissions = Permissions::whereIn('id', $permisisonIds)->get();
            }

            if ($permissions) {
                foreach ($permissions as $permission) {
                    if ((strpos($routeName, $permission->module_name) !== false) &&
                        (strpos($routeName, 'view') === false && $permission->can_view ||
                        strpos($routeName, 'update') !== false && $permission->can_update ||
                        strpos($routeName, 'delete') !== false && $permission->can_delete)
                    ) {
                        return $next($request);
                    }
                }

                return redirect('/dashboard')->with('error', 'You do not have the necessary permissions to access that page.');
            }

            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'You do not have the necessary permissions to access that page.');;
    }
}
