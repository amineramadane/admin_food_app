<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class MigrationSeeder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = User::firstOrCreate(
            [ 'id' => 1 ],
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_superadmin' => true,
            ]
        );

        $adminRole = Role::firstOrCreate(
            [ 'id' => 1 ],
            [
                'name' => 'admin',
                'guard_name' => 'web' 
            ]
        );

        $permissions = array(
            ['name' => 'users_access', 'display_name' => 'Access', 'group_name' => 'Users', 'group_slug' => 'users', 'guard_name' => 'web'],
            ['name' => 'users_create', 'display_name' => 'Create', 'group_name' => 'Users', 'group_slug' => 'users', 'guard_name' => 'web'],
            ['name' => 'users_show', 'display_name' => 'Show', 'group_name' => 'Users', 'group_slug' => 'users', 'guard_name' => 'web'],
            ['name' => 'users_edit', 'display_name' => 'Edit', 'group_name' => 'Users', 'group_slug' => 'users', 'guard_name' => 'web'],
            ['name' => 'users_delete', 'display_name' => 'Delete', 'group_name' => 'Users', 'group_slug' => 'users', 'guard_name' => 'web'],
            ['name' => 'users_ban', 'display_name' => 'Ban/Activate User', 'group_name' => 'Users', 'group_slug' => 'users', 'guard_name' => 'web'],
            ['name' => 'users_activity', 'display_name' => 'Activity Log', 'group_name' => 'Users', 'group_slug' => 'users', 'guard_name' => 'web'],

            ['name' => 'roles_access', 'display_name' => 'Access', 'group_name' => 'Roles', 'group_slug' => 'roles', 'guard_name' => 'web'],
            ['name' => 'roles_create', 'display_name' => 'Create', 'group_name' => 'Roles', 'group_slug' => 'roles', 'guard_name' => 'web'],
            ['name' => 'roles_show', 'display_name' => 'Show', 'group_name' => 'Roles', 'group_slug' => 'roles', 'guard_name' => 'web'],
            ['name' => 'roles_edit', 'display_name' => 'Edit', 'group_name' => 'Roles', 'group_slug' => 'roles', 'guard_name' => 'web'],
            ['name' => 'roles_delete', 'display_name' => 'Delete', 'group_name' => 'Roles', 'group_slug' => 'roles', 'guard_name' => 'web'],

            ['name' => 'permissions_access', 'display_name' => 'Access', 'group_name' => 'Permissions', 'group_slug' => 'permissions', 'guard_name' => 'web'],
            ['name' => 'permissions_create', 'display_name' => 'Create', 'group_name' => 'Permissions', 'group_slug' => 'permissions', 'guard_name' => 'web'],
            ['name' => 'permissions_show', 'display_name' => 'Show', 'group_name' => 'Permissions', 'group_slug' => 'permissions', 'guard_name' => 'web'],
            ['name' => 'permissions_edit', 'display_name' => 'Edit', 'group_name' => 'Permissions', 'group_slug' => 'permissions', 'guard_name' => 'web'],
            ['name' => 'permissions_delete', 'display_name' => 'Delete', 'group_name' => 'Permissions', 'group_slug' => 'permissions', 'guard_name' => 'web'],

            ['name' => 'activitylog_access', 'display_name' => 'Access', 'group_name' => 'Activity Log', 'group_slug' => 'activitylog', 'guard_name' => 'web'],
            ['name' => 'activitylog_show', 'display_name' => 'Show', 'group_name' => 'Activity Log', 'group_slug' => 'activitylog', 'guard_name' => 'web'],
            ['name' => 'activitylog_delete', 'display_name' => 'Delete', 'group_name' => 'Activity Log', 'group_slug' => 'activitylog', 'guard_name' => 'web'],

        );

        Permission::insert($permissions);

        $getPermissions = Permission::get();

        $assignPermissions = $getPermissions->map(function($item){
            return [$item->name];
        });

        $user->assignRole($adminRole);
        $adminRole->givePermissionTo($assignPermissions);

        $userRole = Role::firstOrCreate(
            [ 'id' => 2 ],
            [
                'name' => 'user',
                'guard_name' => 'web'
            ]
        );

        
        $assignUserPermissions = $getPermissions->map(function($item){
            $restrictedPerms = ['users_delete', 'users_ban', 'users_activity', 'roles_delete', 'permissions_delete', 'activitylog_delete'];
            if(!in_array($item->name, $restrictedPerms)){
                return [$item->name];
            }
        });
        $userRole->givePermissionTo($assignUserPermissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
