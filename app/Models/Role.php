<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{

    use HasFactory , SoftDeletes ;
    protected $fillable = [
        'name',
    ];

    // public function permissions(){
    //     return $this->belongsToMany(Permission::class,'role_permissions','role_id','permission_id');
    // }

    public function admin()
    {
        return $this->hasMany(Admin::class);
    }

}
