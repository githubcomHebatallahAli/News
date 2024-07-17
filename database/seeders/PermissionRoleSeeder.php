<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = config('permission.roles');
        $permissions = config('permission.permissions');

        foreach($roles as $role){
            Role::create(["name"=>$role]);
        }
        foreach($permissions as $permission){
            Permission::create(["name"=>$permission]);
        }
    }
    }

