<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;
    public function create(Admin $admin)
    {
        return $admin->role->name === 'Super Admin'||$admin->role->name === 'Admin';
    }

    public function notActive(Admin $admin)
    {
        return $admin->role->name === 'Super Admin'||$admin->role->name === 'Admin';
    }

    public function active(Admin $admin)
    {
        return $admin->role->name === 'Super Admin'|| $admin->role->name === 'Admin';
    }

    public function logout(Admin $admin)
    {

        return true;
}
}
