<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Contact extends Model
{
    protected $fillable = ['email', 'first_name', 'last_name', 'uuid'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function audiences()
    {
        return $this->belongsToMany(Audience::class, 'audience_contact');
    }

    public function getNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}") ?: $this->email;
    }
}
