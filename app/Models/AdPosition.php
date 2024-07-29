<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdPosition extends Model
{
    use HasFactory , SoftDeletes ;

    protected $fillable = [
        'position'

    ];

    public function ads()
    {
        return $this->hasMany(Ad::class ,'ad_position_id');
    }



}
