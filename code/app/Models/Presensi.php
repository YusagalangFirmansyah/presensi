<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category',
        'status',
        'description',
        'device',
        'platform',
        'platform_version',
        'browser',
        'browser_version',
        'user_id',
    ];

    public function absenHasPresensis()
    {
        return $this->hasMany(AbsenHasPresensi::class, 'checkin', 'id');
    }

    public function absenHasPresensisCheckout()
    {
        return $this->hasMany(AbsenHasPresensi::class, 'checkout', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
