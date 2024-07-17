<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertisment extends Model
{
    use HasFactory , SoftDeletes ;
    const storageFolder= 'Advertisments';
    protected $fillable = [
        'img',
        'url'
    ];
}
