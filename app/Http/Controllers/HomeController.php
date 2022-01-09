<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokter;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Admin;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'dokter') {
                $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);

                $datapendaftaran = DB::connection('mysql')
                ->table(DB::raw("(select coalesce(count(*),0) jml from pendaftarans where date_format(tgl_pendaftaran,'%Y-%m-%d') = date_format(sysdate(),'%Y-%m-%d')) x"))->first();
                $datapemeriksaan = DB::connection('mysql')
                ->table(DB::raw("(select coalesce(count(*),0) jml from pemeriksaans where date_format(tgl_pemeriksaan,'%Y-%m-%d') = date_format(sysdate(),'%Y-%m-%d') and id_dokter = '$iddokter->id_dokter') x"))->first();
                return view('dokter.home')->with(compact('datapendaftaran','datapemeriksaan'));
            }

            if (Auth::user()->role == 'pasien') {
                return view('pasien.home');
            }

            if (Auth::user()->role == 'admin') {
                $countpasien = DB::connection('mysql')
                ->table(DB::raw("(select count(*) jml from pasiens) x"))
                ->first();
                $countdokter = DB::connection('mysql')
                ->table(DB::raw("(select count(*) jml from dokters) x"))
                ->first();
                return view('admin.home')->with(compact('countpasien','countdokter'));
            }
        }

        return view('errors.404');
    }
}
