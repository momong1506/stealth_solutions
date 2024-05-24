<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Permissions;
use App\Models\RolePermissions;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * View for users
     */
    public function index()
    {
        $userInstance = new User();

        $users = $userInstance->getUserWithRole();

        $userRoles = UserRoles::all();

        return view('user_management.users', [
            'users' => $users,
            'user_roles' => $userRoles,
        ]);
    }

    /**
     * View for permissions
     *
     */
    public function permissions()
    {
        $permissions = Permissions::all();

        return view('user_management.permissions', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * View for Role
     *
     */
    public function userRoles()
    {
        $userRoles = UserRoles::with(['rolePermissions'])->get();
        $permissions = Permissions::all();

        $compilePermissionsPerUserRole = [];

        foreach ($userRoles as $userRole) {
            if (!empty($userRole->rolePermissions)) {
                $compilePermissionIds = [];

                foreach ($userRole->rolePermissions as $rolePermission) {
                    $compilePermissionIds[] = $rolePermission->permissions_id;
                }

                if ($compilePermissionIds) {
                    $permissionInstance = new Permissions();
                    $compilePermissionsPerUserRole[] = [
                        'user_role' => $userRole,
                        'permissions' => $permissionInstance->whereIn('id', $compilePermissionIds)->get(),
                    ];
                }
            }
        }

        return view('user_management.user_roles', [
            'user_roles' => $compilePermissionsPerUserRole,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Api for updating user
     *
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function updateUser(UpdateRequest $request): JsonResponse
    {
        $userInstance = new User();
        $updated = $userInstance->updateUser($request->input('id'), $request->all());

        return response()->json([
            'message' => $updated ? 'Successfully updated' : 'Failed to update',
            'code' => $updated ? Response::HTTP_OK : Response::HTTP_ACCEPTED,
        ]);
    }

    /**
     * Api for create permission
     *
     * @param PermissionRequest $request
     * @return JsonResponse
     */
    public function createPermission(PermissionRequest $request): JsonResponse
    {
        $payload = [
            'module_name' => $request->input('module_name'),
            'can_view' => !empty($request->input('can_view')),
            'can_create' => !empty($request->input('can_create')),
            'can_update' => !empty($request->input('can_update')),
            'can_delete' => !empty($request->input('can_delete')),
        ];

        $permissionInstance = new Permissions();

        $created = $permissionInstance->createPermission($payload);

        return response()->json([
            'message' => $created ? 'Successfully created' : 'Failed to create',
            'code' => $created ? Response::HTTP_CREATED : Response::HTTP_ACCEPTED,
        ]);
    }

    /**
     * Api for updating permission
     *
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function updatePermission(UpdateRequest $request): JsonResponse
    {
        $payload = [
            'module_name' => $request->input('module_name'),
            'can_view' => !empty($request->input('can_view')),
            'can_create' => !empty($request->input('can_create')),
            'can_update' => !empty($request->input('can_update')),
            'can_delete' => !empty($request->input('can_delete')),
        ];

        $permissionInstance = new Permissions();

        $created = $permissionInstance->updatePermission($request->input('id'), $payload);

        return response()->json([
            'message' => $created ? 'Successfully created' : 'Failed to create',
            'code' => $created ? Response::HTTP_OK : Response::HTTP_ACCEPTED,
        ]);
    }

    /**
     * Api for deleting permission
     *
     * @param DeleteRequest $request
     */
    public function deletePermission(DeleteRequest $request)
    {
        $recordId = $request->input('id');

        $permissionInstance = new Permissions();
        $permissionInstance->deletePermission($recordId);

        return redirect('permissions');
    }

    /**
     * Api for create role
     *
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function createRole(RoleRequest $request): JsonResponse
    {
        $permissionData = $request->input('permissions');

        $payload = [
            'role_name' => $request->input('role_name'),
        ];

        $userRoleInstance = new UserRoles();
        $created = $userRoleInstance->createRole($payload);


        if (!empty($permissionData)) {
            foreach ($permissionData as $permission) {
                $rolePermissionInstance = new RolePermissions();
                $rolePermissionPayload = [
                    'user_roles_id' => $created->id,
                    'permissions_id' => $permission,
                ];
                $rolePermissionInstance->createRolePermission($rolePermissionPayload);
            }
        }

        return response()->json([
            'message' => $created ? 'Successfully created' : 'Failed to create',
            'code' => $created ? Response::HTTP_CREATED : Response::HTTP_ACCEPTED,
        ]);
    }

    /**
     * Api for updating role
     *
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function updateRole(UpdateRequest $request): JsonResponse
    {
        $recordId = $request->input('id');

        $permissionData = $request->input('permissions');

        $payload = [
            'role_name' => $request->input('role_name'),
        ];

        $userRoleInstance = new UserRoles();
        $userRolePermissionInstance = new RolePermissions();

        $updated = $userRoleInstance->updateRole($recordId, $payload);
        $userRolePermissionInstance->deleteRolePermission($recordId);

        if (!empty($permissionData)) {
            foreach ($permissionData as $permission) {
                $rolePermissionInstance = new RolePermissions();
                $rolePermissionPayload = [
                    'user_roles_id' => $recordId,
                    'permissions_id' => $permission,
                ];
                $rolePermissionInstance->createRolePermission($rolePermissionPayload);
            }
        }

        return response()->json([
            'message' => $updated ? 'Successfully updated' : 'Failed to update',
            'code' => $updated ? Response::HTTP_OK : Response::HTTP_ACCEPTED,
        ]);
    }

    /**
     * Api for deleting role
     *
     * @param DeleteRequest $request
     */
    public function deleteRole(DeleteRequest $request)
    {
        $recordId = $request->input('id');

        $rolePermissionInstance = new RolePermissions();
        $rolePermissionInstance->deleteRolePermission($recordId);

        $userRoleInstance = new UserRoles();
        $userRoleInstance->deleteRole($recordId);

        return redirect('user_roles');
    }

    /**
     * Api to process change password of user
     *
     * @param ChangePasswordRequest $request
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $userId = $request->input('user_id');
        $password = Hash::make($request->input('password'));

        $userInstance = new User();
        $userInstance->updateUser($userId, ['password' => $password]);

        return back();
    }
}