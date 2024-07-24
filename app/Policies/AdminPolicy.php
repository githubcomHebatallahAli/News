<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;
    public function create(Admin $admin)
    {
        return $admin->role_id === 1;
    }
}
