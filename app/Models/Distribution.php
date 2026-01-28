<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function offering()
    {
        return $this->belongsTo(Offering::class);
    }
}
