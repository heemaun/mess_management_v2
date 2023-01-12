<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'status',
        'password',
        'recovary_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function months()
    {
        return $this->hasMany(Month::class);
    }
    public function members()
    {
        return $this->hasMany(Member::class);
    }
    public function membersMonths()
    {
        return $this->hasMany(MemberMonth::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function notices()
    {
        return $this->hasMany(Notice::class);
    }
    public function adjustments()
    {
        return $this->hasMany(Adjustment::class);
    }
}
