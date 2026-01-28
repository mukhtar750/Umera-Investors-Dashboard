<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['subject', 'content', 'template', 'status', 'sent_at'];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function audiences()
    {
        return $this->belongsToMany(Audience::class, 'campaign_audience');
    }
}
