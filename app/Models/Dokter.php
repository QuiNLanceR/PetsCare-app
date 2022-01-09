<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dokter extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email_dokter',
        'nm_dokter',
        'username',
        'tmp_lah_dokter',
        'tgl_lah_dokter',
        'jen_kel_dokter',
        'no_hp_dokter',
        'photo_dokter'
    ];
}
