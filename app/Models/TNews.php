<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TNews extends Model
{
    use HasFactory , SoftDeletes ;
    protected $fillable = [
        'content',
        'trending_news_id'
    ];

    public function trendingNews()
    {
        return $this->belongsTo(TrendingNews::class);
    }

}
