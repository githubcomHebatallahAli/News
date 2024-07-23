<?php

namespace App\Policies;

use App\Models\News;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
use HandlesAuthorization;
protected $rolesCache = [];

protected function getRoleNameById($id)
{
    // Cache roles to avoid multiple DB queries
    if (!isset($this->rolesCache[$id])) {
        $role = Role::find($id);
        $this->rolesCache[$id] = $role ? $role->name : '';
    }
    return $this->rolesCache[$id];
}

protected function checkRole(Admin $admin, array $allowedRoles)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    Log::info('Admin role checking:', ['role' => $roleName]);
    return in_array($roleName, $allowedRoles);
}

public function showAll(Admin $admin)
{
    return $this->checkRole($admin, ['Super Admin', 'Admin', 'Reviewer', 'Writer']);
}

public function create(Admin $admin)
{
    return $this->checkRole($admin, ['Writer', 'Super Admin', 'Admin', 'Reviewer']);
}

public function edit(Admin $admin)
{
    return $this->checkRole($admin, ['Writer', 'Super Admin', 'Admin', 'Reviewer']);
}

public function update(Admin $admin)
{
    return $this->checkRole($admin, ['Writer', 'Super Admin', 'Admin', 'Reviewer']);
}

public function softDelete(Admin $admin)
{
    return $this->checkRole($admin, ['Super Admin', 'Admin']);
}

public function showDeleted(Admin $admin)
{
    return $this->checkRole($admin, ['Super Admin', 'Admin']);
}

public function restore(Admin $admin)
{
    return $this->checkRole($admin, ['Super Admin', 'Admin']);
}

public function forceDelete(Admin $admin)
{
    return $this->checkRole($admin, ['Super Admin', 'Admin']);
}

public function review(Admin $admin, News $news)
{
    return $this->checkRole($admin, ['Reviewer', 'Admin', 'Super Admin']);
}

public function reject(Admin $admin, News $news)
{
    return $this->checkRole($admin, ['Reviewer', 'Admin', 'Super Admin']);
}

public function publish(Admin $admin, News $news)
{
    return $this->checkRole($admin, ['Admin', 'Super Admin']);
}
}




