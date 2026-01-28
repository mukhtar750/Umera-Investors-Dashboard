<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    protected $fillable = ['name', 'description'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'audience_contact');
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_audience');
    }
}
