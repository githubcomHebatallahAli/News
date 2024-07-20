<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory , SoftDeletes ;
    protected $fillable = [
        'categoryName',
        'title',
        'writer',
        'event_date',
        'img',
        'part1',
        'part2',
        'part3',
        'keyWords',
        'category_id',
    ];
}
