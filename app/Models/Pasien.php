<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pasien extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik_pasien',
        'nm_pasien',
        'email_pasien',
        'tmp_lah_pasien',
        'tgl_lah_pasien',
        'jen_kel_pasien',
        'no_hp_pasien',
        'alamat_pasien',
        'photo_pasien'
    ];
}
