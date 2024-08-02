<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertisement extends Model
{
    use HasFactory , SoftDeletes ;
    const storageFolder= 'Advertisements';
    protected $fillable = [
        'img',
        'url',
        'ad_position_id'
    ];

    public function position()
    {
        return $this->belongsTo(AdPosition::class, 'ad_position_id');
    }
}
