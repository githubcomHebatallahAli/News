<?php

namespace App\Policies;

use App\Models\News;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
use HandlesAuthorization;
protected function getRoleNameById($id)
{
    return Role::find($id)->name ?? '';
}

 public function showAll(Admin $admin)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    // Define the roles that are allowed to show all
    return in_array($roleName, ['Super Admin', 'Admin','Reviewer','Writer']);
}
public function create(Admin $admin)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Writer', 'Super Admin', 'Admin', 'Reviewer']);
}

public function edit(Admin $admin)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Writer', 'Super Admin', 'Admin', 'Reviewer']);
}

public function update(Admin $admin)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Writer', 'Super Admin', 'Admin', 'Reviewer']);
}

public function softDelete(Admin $admin)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Super Admin', 'Admin']);
}

public function showDeleted(Admin $admin)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Super Admin', 'Admin']);
}

public function restore(Admin $admin)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Super Admin', 'Admin']);
}

public function forceDelete(Admin $admin)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Super Admin', 'Admin']);
}

public function review(Admin $admin, News $news)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Reviewer', 'Admin', 'Super Admin']);
}

public function reject(Admin $admin, News $news)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Reviewer', 'Admin', 'Super Admin']);
}

public function publish(Admin $admin, News $news)
{
    $roleName = $this->getRoleNameById($admin->role_id);
    return in_array($roleName, ['Admin', 'Super Admin']);
}



}
