<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    protected $table = 'months';

    protected $fillable = [
        'user_id',
        'name',
        'status'
    ];
    public function monthName()
    {
        $month = Month::find($this->id);
        return date('F-Y',strtotime($month->month_name));
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function members()
    {
        return $this->belongsToMany(Member::class,'members_months');
    }
    public function memberMonths()
    {
        return $this->hasMany(MemberMonth::class);
    }
}
