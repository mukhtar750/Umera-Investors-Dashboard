<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'wallet_balance',
        'custom_fields',
        'dob',
        'address',
        'next_of_kin_name',
        'next_of_kin_email',
        'next_of_kin_relationship',
        'next_of_kin_phone',
        'must_reset_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'custom_fields' => 'array',
            'phone' => 'encrypted',
            'dob' => 'encrypted',
            'address' => 'encrypted',
            'next_of_kin_name' => 'encrypted',
            'next_of_kin_email' => 'encrypted',
            'next_of_kin_relationship' => 'encrypted',
            'next_of_kin_phone' => 'encrypted',
        ];
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
