<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email_admin',
        'nm_admin',
        'username',
        'tmp_lah_admin',
        'tgl_lah_admin',
        'jen_kel_admin',
        'no_hp_admin',
        'photo_admin'
    ];
}
