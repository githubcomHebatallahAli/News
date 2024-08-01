<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuggestedNews extends Model
{
    use HasFactory, SoftDeletes ;

    protected $fillable = [
        'label',
        'url',
    ];

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_suggested_news','news_id', 'suggested_news_id');
    }
}
