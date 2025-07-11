<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'date',
        'reason',
        'attachment',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
