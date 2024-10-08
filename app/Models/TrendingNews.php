<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrendingNews extends Model
{
    use HasFactory , SoftDeletes ;
    protected $fillable = [
        'title',
    ];

    public function news()
    {
        return $this->hasMany(TNews::class);
    }
}
