<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'picture',
        'initial_balance',
        'current_balance',
        'joining_date',
        'leaving_date',
        'floor',
        'status',
    ];

    public function months()
    {
        return $this->belongsToMany(Month::class,'members_months');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function memberMonths()
    {
        return $this->hasMany(MemberMonth::class);
    }
}
