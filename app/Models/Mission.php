<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mission extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'sub_title', 'name', 'sub_name', 'image', 'description'];

    
    
}
