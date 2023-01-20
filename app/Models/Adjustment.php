<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use HasFactory;

    protected $table = 'adjustments';

    protected $fillable = [
        'user_id',
        'member_month_id',
        'type',
        'amount',
        'status',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function memberMonth()
    {
        return $this->belongsTo(MemberMonth::class);
    }
}
