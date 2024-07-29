<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory , SoftDeletes ;
    protected $fillable = [
        'code',
        'ad_position_id'
    ];

    public function position()
    {
        return $this->belongsTo(AdPosition::class, 'ad_position_id');
    }
}
