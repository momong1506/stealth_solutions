<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserWithRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'module_name' => 'user_roles',
            'can_view' => true,
            'can_create' => true,
            'can_update' => true,
            'can_delete' => true,
        ]);

        DB::table('permissions')->insert([
            'module_name' => 'permissions',
            'can_view' => true,
            'can_create' => true,
            'can_update' => true,
            'can_delete' => true,
        ]);

        DB::table('permissions')->insert([
            'module_name' => 'users',
            'can_view' => true,
            'can_create' => true,
            'can_update' => true,
            'can_delete' => true,
        ]);

        DB::table('permissions')->insert([
            'module_name' => 'categories',
            'can_view' => true,
            'can_create' => true,
            'can_update' => true,
            'can_delete' => true,
        ]);

        DB::table('permissions')->insert([
            'module_name' => 'products',
            'can_view' => true,
            'can_create' => true,
            'can_update' => true,
            'can_delete' => true,
        ]);

        DB::table('user_roles')->insert([
            'role_name' => 'Admin',
        ]);

        DB::table('user_roles')->insert([
            'role_name' => 'Users',
        ]);

        DB::table('role_permissions')->insert([
            'user_roles_id' => 1,
            'permissions_id' => 1,
        ]);

        DB::table('role_permissions')->insert([
            'user_roles_id' => 1,
            'permissions_id' => 2,
        ]);

        DB::table('role_permissions')->insert([
            'user_roles_id' => 1,
            'permissions_id' => 3,
        ]);

        DB::table('role_permissions')->insert([
            'user_roles_id' => 1,
            'permissions_id' => 4,
        ]);

        DB::table('role_permissions')->insert([
            'user_roles_id' => 1,
            'permissions_id' => 5,
        ]);

        DB::table('role_permissions')->insert([
            'user_roles_id' => 2,
            'permissions_id' => 4,
        ]);

        DB::table('role_permissions')->insert([
            'user_roles_id' => 2,
            'permissions_id' => 5,
        ]);

        DB::table('users')->insert([
            'name' => 'Admin Only',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'user_roles_id' => 1,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'User Only',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'user_roles_id' => 2,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
