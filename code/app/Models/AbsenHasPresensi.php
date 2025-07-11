<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsenHasPresensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'absen_has_presensis';

    protected $fillable = [
        'absen_id',
        'checkin_id',
        'checkout_id',
    ];

    public function absen()
    {
        return $this->belongsTo(Absen::class, 'absen_id', 'id');
    }

    public function checkin()
    {
        return $this->belongsTo(Presensi::class, 'checkin_id', 'id');
    }

    public function checkout()
    {
        return $this->belongsTo(Presensi::class, 'checkout_id', 'id');
    }
}
