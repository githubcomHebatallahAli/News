<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminProfile extends Model
{
    use HasFactory , SoftDeletes ;
    const storageFolder= 'AdminProfile';
    protected $fillable = [
        'admin_id',
        'photo'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }



}
