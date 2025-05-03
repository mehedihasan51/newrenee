<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class election extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'sub_title',
        'name',
        'description',
        'button_text',
        'image',
        'sub_name',
        'sub_description',
        'user_id',
    ];
    protected $table = 'elections';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
