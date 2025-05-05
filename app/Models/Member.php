<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'representative_button',
        'senator_button',
        'image',

    ];

    protected $casts = [
        'title' => 'string',
        'sub_title' => 'string',
        'description' => 'string',
        'representative_button' => 'string',
        'senator_button' => 'string',
        'image' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
