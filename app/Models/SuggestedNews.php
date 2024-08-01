<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuggestedNews extends Model
{
    use HasFactory, SoftDeletes ;

    protected $fillable = [
       'news_id',
        'suggested_news_id'
    ];


    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    // الحصول على الأخبار المقترحة
    public function suggested()
    {
        return $this->belongsTo(News::class, 'suggested_news_id');
    }
}
