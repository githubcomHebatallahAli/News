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
        'description',
        'writer',
        'event_date',
        'img',
        'videoUrl',
        'videoLabel',
        'url',
        'part1',
        'part2',
        'part3',
        'keyWords',
        'category_id',
        'admin_id',
        'status',
        'adsenseCode',
    ];

    protected $casts = [
        'keyWords' => 'array',

    ];
    // الحصول على الأخبار المقترحة لهذا الخبر
    public function suggestedNews()
    {
        return $this->hasMany(SuggestedNews::class, 'news_id');
    }

    // الحصول على الأخبار المقترحة الأخرى
    public function suggestions()
    {
        return $this->hasMany(SuggestedNews::class, 'suggested_news_id');
    }



    public function incrementViews()
    {
        $this->increment('news_views_count');
    }

    // protected static function booted()
    // {
    //     static::retrieved(function ($news) {
    //         // زيادة عدد المشاهدات تلقائيًا عند استرجاع الخبر
    //         $news->incrementViews();
    //     });
    // }

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



    protected static function boote()
    {
        static::created(function ($news) {
            $news->category->increment('news_count');
        });

        static::deleted(function ($news) {
            $news->category->decrement('news_count');
        });
    }



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bestNews()
    {
        return $this->hasOne(BestNews::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function slider()
    {
        return $this->hasMany(Slider::class);
    }

    public function trNews()
    {
        return $this->hasMany(TNews::class);
    }

}
