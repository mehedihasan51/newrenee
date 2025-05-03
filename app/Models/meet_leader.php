<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class meet_leader extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'position',
        'subtitle',
        'description',
        'name',
        'image',
        'status'
    ];

    protected $dates = ['deleted_at'];
}
