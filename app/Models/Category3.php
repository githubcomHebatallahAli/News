<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category3 extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id'
    ];

    public function category()
{
    return $this->belongsTo(Category::class);
}

protected static function boot()
{
    parent::boot();

    static::created(function ($category3) {
        // احصل على آخر 6 أخبار منشورة
        $latestNews = News::where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->take(6)
                          ->get();

        // اربط الأخبار بالفئة المرتبطة في Category3
        foreach ($latestNews as $news) {
            $news->category()->associate($category3->category);
            $news->save();
        }
    });
}

}
