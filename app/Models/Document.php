<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_ACTIVE = 'active';

    const STATUS_PENDING_SIGNATURE = 'pending_signature';

    const STATUS_SIGNED = 'signed';

    public function offering()
    {
        return $this->belongsTo(Offering::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
