<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'member_month_id',
        'amount',
        'note',
        'status',
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
