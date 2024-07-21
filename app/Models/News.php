<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory , SoftDeletes ;
    const storageFolder= 'News';
    protected $fillable = [
        'title',
        'writer',
        'event_date',
        'img',
        'url',
        'part1',
        'part2',
        'part3',
        'keyWords',
        'category_id',
    ];

    protected $casts = [
        'keyWords' => 'array', // تحويل البيانات إلى مصفوفة تلقائيًا عند الاسترجاع
    ];



    public function incrementViews()
    {
        $this->increment('news_views_count');
    }

    protected static function booted()
    {
        static::retrieved(function ($news) {
            // زيادة عدد المشاهدات تلقائيًا عند استرجاع الخبر
            $news->incrementViews();
        });
    }

    protected $dates = ['event_date'];

    protected $appends = ['formatted_date'];

    protected $hidden = ['event_date'];

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->event_date)->format('M d, Y');
    }

    public static function boot()
    {
        parent::boot();

        // تعيين التاريخ تلقائياً إلى تاريخ اليوم الحالي إذا لم يتم تقديمه
        static::creating(function ($model) {
            if (is_null($model->event_date)) {
                $model->event_date = Carbon::now();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boote()
    {
        static::created(function ($news) {
            $news->category->increment('news_count');
        });

        static::deleted(function ($news) {
            $news->category->decrement('news_count');
        });
    }

    public function views()
    {
        return $this->hasMany(NewsView::class);
    }

    public function bestNews()
    {
        return $this->hasOne(BestNews::class);
    }
}
