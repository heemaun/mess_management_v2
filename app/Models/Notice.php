<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $table = 'notices';

    protected $fillable = [
        'user_id',
        'heading',
        'body',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
