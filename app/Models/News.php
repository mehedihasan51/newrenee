<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'sub_title',
        'category',
        'report',
        'news_type',
        'name',
        'description',
        'image',
        'status',

    ];
    protected $casts = [
        'status' => 'string',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
