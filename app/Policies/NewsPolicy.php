<?php

namespace App\Policies;

use App\Models\News;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
use HandlesAuthorization;
public function create(Admin $admin)
{
    return $admin->role->name === 'Writer'|| $admin->role->name === 'Super Admin'
    || $admin->role->name === 'Admin'|| $admin->role->name === 'Reviewer';
}

public function edit(Admin $admin)
{
    return $admin->role->name === 'Writer'|| $admin->role->name === 'Super Admin'
        || $admin->role->name === 'Admin'|| $admin->role->name === 'Reviewer';
}

public function update(Admin $admin)
{
    return $admin->role->name === 'Writer'|| $admin->role->name === 'Super Admin'
        || $admin->role->name === 'Admin'|| $admin->role->name === 'Reviewer';
}
public function softDelete(Admin $admin)
{
    return $admin->role->name === 'Super Admin'|| $admin->role->name === 'Admin';
}
public function showDeleted(Admin $admin)
{
    return $admin->role->name === 'Super Admin'|| $admin->role->name === 'Admin';
}

public function restore(Admin $admin)
{
    return  $admin->role->name === 'Super Admin'|| $admin->role->name === 'Admin';
}

public function forceDelete(Admin $admin)
{
    return $admin->role->name === 'Super Admin'|| $admin->role->name === 'Admin';
}

public function review(Admin $admin, News $news)
{
    return $admin->role->name === 'Reviewer'|| $admin->role->name === 'Admin'
    || $admin->role->name === 'Super Admin';
}

public function reject(Admin $admin, News $news)
{
    return $admin->role->name === 'Reviewer'|| $admin->role->name === 'Admin'
    || $admin->role->name === 'Super Admin';
}


public function publish(Admin $admin, News $news)
{
    return $admin->role->name === 'Admin' || $admin->role->name === 'Super Admin';
}

}
