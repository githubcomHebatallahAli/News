<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category6 extends Model
{
    use HasFactory  , SoftDeletes;
    protected $fillable = [
        'category_id'
    ];

    public function category()
{
    return $this->belongsTo(Category::class);
}

}
