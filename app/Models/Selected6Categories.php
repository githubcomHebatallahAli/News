<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selected6Categories extends Model
{
    use HasFactory;

    protected $fillable = ['category_ids'];

    protected $casts = [
        'category_ids' => 'array', 
    ];
}
