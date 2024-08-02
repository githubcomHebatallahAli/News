<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuggestedNews extends Model
{
    use HasFactory ;

    protected $fillable = [
       'news_id',
        'suggested_news_id'
    ];


    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }




public function suggestedNews()
{
    return $this->belongsTo(News::class, 'suggested_news_id');
}

}
