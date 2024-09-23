<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory , SoftDeletes ;
    protected $fillable = [
        'name',
        'url',
        'views_count',
        'news_count',

    ];

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function Category3()
{
    return $this->hasMany(Category3::class);
}

    public function Category6()
{
    return $this->hasMany(Category6::class);
}



    public function bestNews()
    {
        return $this->hasManyThrough(BestNews::class, News::class, 'category_id', 'news_id');
    }



    public function incrementViews()
    {
        $this->increment('views_count');
    }



    protected static function booted()
{
    static::created(function ($category) {
        $category->news_count = $category->news()->count();
        $category->save();
    });

    static::deleted(function ($category) {
        if (!$category->trashed()) {
            $category->news_count = $category->news()->count();
            $category->save();
        }
    });
}


       /**
     * Accessor for the news count.
     *
     * @return int
     */
    public function getNewsCountAttribute()
    {
        return $this->news()->count();
    }



}
