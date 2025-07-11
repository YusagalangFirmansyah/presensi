<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absen extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['day', 'date', 'user_id'];

    public function absenHasPresensis()
    {
        return $this->hasMany(AbsenHasPresensi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
