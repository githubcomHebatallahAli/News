<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BestNews extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'news_id'
    ];
    
    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
