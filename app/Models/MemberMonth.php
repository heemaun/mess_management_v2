<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberMonth extends Model
{
    use HasFactory;

    protected $table = 'members_months';

    protected $fillable = [
        'member_id',
        'month_id',
        'due',
        'rent_this_month',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function month()
    {
        return $this->belongsTo(Month::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function adjustments()
    {
        return $this->hasMany(Adjustment::class);
    }
}
