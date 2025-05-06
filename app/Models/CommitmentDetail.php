<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommitmentDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function commitment()
    {
        return $this->belongsTo(Commitment::class);
    }
}
