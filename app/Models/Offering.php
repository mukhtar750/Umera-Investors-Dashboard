<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offering extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
}
