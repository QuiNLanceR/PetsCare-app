<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Dokter;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Admin;
use DB;
use Exception;
use stdClass;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Intervention\Image\ImageManagerStatic as Image;
use PDF;
use Excel;
use JasperPHP\JasperPHP;
use DNS2D;
use DNS1D;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $countpasien = DB::connection('mysql')
            ->table(DB::raw("(select count(*) jml from pasiens) x"))
            ->first();
            $countdokter = DB::connection('mysql')
            ->table(DB::raw("(select count(*) jml from dokters) x"))
            ->first();
            return view('admin.home')->with(compact('countpasien','countdokter'));
        } else {
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function indexdatadokter(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.indexdatadokter');
        } else {
            return view('errrors.403');
        }
    }

    public function dashboarddatadokter(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            if ($request->ajax()) {
                $list = DB::connection('mysql')
                ->table(DB::raw("(select * from dokters)x"));

                return DataTables::of($list)
                ->editColumn('ttl',function($lists){
                    return ucfirst($lists->tmp_lah_dokter) . ', ' . Carbon::parse($lists->tgl_lah_dokter)->format('d F Y');
                })
                ->editColumn('jen_kel_dokter',function($lists){
                    return $lists->jen_kel_dokter == 'l' ? 'Laki-Laki' : 'Perempuan';
                })
                ->editColumn('photo_dokter', function($lists){
                    if ($lists->photo_dokter != null) {
                        $img = '<img src="'.asset("images/photo/$lists->photo_dokter").'" style="width:50px; height:70px;" alt="Photo Dokter">';
                    } else {
                        $img = '<img src="'.asset("images/no_image.png").'" style="width:50px; height:70px;" alt="Photo Dokter">';
                    }
                    return $img;
                })
                ->rawColumns(['photo_dokter','action'])
                ->editColumn('action', function($lists){
                    return "<span class='btn btn-success btn-xs' title='Edit Data' onclick='window.open(\"".route('admin.editdatadokter',base64_encode($lists->id_dokter))."\")'><i class='fas fa-edit'></i> </span> <span onclick='hapusdata(\"".base64_encode($lists->id_dokter)."\",\"".base64_encode($lists->username)."\")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fas fa-trash'></i> </span>";
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function createdatadokter()
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.createdatadokter');
        } else {
            return view('errrors.403');
        }
    }

    public function storedatadokter(Request $request)
    {
        if (Auth::user()->role == 'admin') {

            $request->validate([
                'photo_dokter' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4980',
            ]);
            
            try {
                $cekdata1 = DB::connection('mysql')
                ->table(DB::raw("(select count(*) jml from users where username = '$request->username')x"))->first();

                if ($cekdata1->jml > 0) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data Gagal diSimpan!, Karena: Username sudah terdaftar"
                    ]);
                    return redirect()->route('admin.createdatadokter');
                } else {
                    $cekdata2 = DB::connection('mysql')
                    ->table(DB::raw("(select count(*) jml from users where email = '$request->email_dokter')x"))->first();

                    if ($cekdata2->jml > 0) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data Gagal diSimpan!, Karena: Email sudah terdaftar"
                        ]);
                        return redirect()->route('admin.createdatadokter');
                    } else {
                        DB::beginTransaction();

                        if ($request->hasFile('photo_dokter')) {
                            $image = $request->file('photo_dokter'); 
                            $destinationPath = public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'photo';
                            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                            $image->move($destinationPath, $profileImage);
                            $photo_dokter = "$profileImage";
                        } else {
                            $photo_dokter = null;
                        }

                        Dokter::create([
                            'email_dokter' => $request->email_dokter,
                            'username' => $request->username,
                            'nm_dokter' => $request->nm_dokter,
                            'tmp_lah_dokter' => $request->tmp_lah_dokter,
                            'tgl_lah_dokter' => $request->tgl_lah_dokter,
                            'jen_kel_dokter' => $request->jen_kel_dokter,
                            'no_hp_dokter' => $request->no_hp_dokter,
                            'photo_dokter' => $photo_dokter,
                        ]);

                        User::create([
                            'name' => $request->nm_dokter,
                            'username' => $request->username,
                            'email' => $request->email_dokter,
                            'role' => 'dokter',
                            'password' => Hash::make($request->password),
                        ]);
                        
                        DB::commit();
                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Data Berhasil diSimpan!"
                        ]);
                        return redirect()->route('admin.indexdatadokter');

                    }
                }
            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);
                return redirect()->route('admin.createdatadokter');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function deletedatadokter(Request $request, $id, $username) 
    {
        if (Auth::user()->role == 'admin') {
            try {
                $username = base64_decode($username);
                $id = base64_decode($id);

                $photo = Dokter::select('photo_dokter')->where('id_dokter',$id)->first();
                if ($photo != null) {
                    $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'photo' . DIRECTORY_SEPARATOR . $photo->photo_dokter;
                    if(File::exists($destinationPath)) {
                        File::delete($destinationPath);
                    }
                }

                DB::beginTransaction();

                DB::connection('mysql')
                ->table('users')
                ->where('username', $username)
                ->delete();

                DB::connection('mysql')
                ->table('dokters')
                ->where('id_dokter', $id)
                ->delete();

                DB::commit();
                return response()->json(['indctr' => '1', 'msg' => 'Data Berhasil diHapus!']);
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['indctr' => '0', 'msg' => 'Karena: '.$e]);
            }
        } else {
            return view('errrors.403');
        }
    }

    public function editdatadokter(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {
            $datadokter = DB::connection('mysql')
            ->table('dokters')
            ->where('id_dokter', base64_decode($id))
            ->first();

            return view('admin.editdatadokter')->with(compact('datadokter'));
        } else {
            return view('errrors.403');
        }
    }

    public function updatedatadokter(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {

            $request->validate([
                'photo_dokter' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4980',
            ]);

            try {

                $id = base64_decode($id);

                $username = Dokter::select('*')->where('id_dokter',$id)->first();
                $photo_lama = $username->photo_dokter;


                if ($request->hasFile('photo_dokter')) {
                    $image = $request->file('photo_dokter'); 
                    $destinationPath = public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'photo';
                    $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                    $photo_dokter = "$profileImage";

                    //hapus photolama
                    if ($photo_lama != null) {
                        $photopath = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'photo' . DIRECTORY_SEPARATOR . $photo_lama;
                        if(File::exists($photopath)) {
                            File::delete($photopath);
                        }                        
                    }
                } else {
                    $photo_dokter = $photo_lama;
                }

                DB::beginTransaction();

                Dokter::where('id_dokter',$id)
                ->update([
                    'nm_dokter' => $request->nm_dokter,
                    'tmp_lah_dokter' => $request->tmp_lah_dokter,
                    'tgl_lah_dokter' => $request->tgl_lah_dokter,
                    'no_hp_dokter' => $request->no_hp_dokter,
                    'jen_kel_dokter' => $request->jen_kel_dokter,
                    'photo_dokter' => $photo_dokter,
                ]);

                User::where('username',$username->username)
                ->update([
                    'name' => $request->nm_dokter,
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil diUbah!"
                ]);
                return redirect()->route('admin.indexdatadokter');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);

                $datadokter = DB::connection('mysql')
                ->table('dokters')
                ->where('id_dokter', base64_decode($id))
                ->first();

                return view('admin.editdatadokter')->with(compact('datadokter'));
            }
        } else {
            return view('errrors.403');
        }        
    }

    public function indexdatapasien(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.indexdatapasien');
        } else {
            return view('errrors.403');
        }
    }

    public function dashboarddatapasien(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            if ($request->ajax()) {
                $list = DB::connection('mysql')
                ->table(DB::raw("(select * from pasiens)x"));

                return DataTables::of($list)
                ->editColumn('ttl',function($lists){
                    return ucfirst($lists->tmp_lah_pasien) . ', ' . Carbon::parse($lists->tgl_lah_pasien)->format('d F Y');
                })
                ->editColumn('jen_kel_pasien',function($lists){
                    return $lists->jen_kel_pasien == 'l' ? 'Laki-Laki' : 'Perempuan';
                })
                ->editColumn('photo_pasien', function($lists){
                    if ($lists->photo_pasien != null) {
                        $img = '<img src="'.asset("images/photo/$lists->photo_pasien").'" style="width:50px; height:70px;" alt="Photo Dokter">';
                    } else {
                        $img = '<img src="'.asset("images/no_image.png").'" style="width:50px; height:70px;" alt="Photo Dokter">';
                    }
                    return $img;
                })
                ->rawColumns(['photo_pasien','action'])
                ->editColumn('action', function($lists){
                    return "<span class='btn btn-success btn-xs' title='Edit Data' onclick='window.open(\"".route('admin.editdatapasien',base64_encode($lists->nik_pasien))."\")'><i class='fas fa-edit'></i> </span> <span onclick='hapusdata(\"".base64_encode($lists->nik_pasien)."\")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fas fa-trash'></i> </span>";
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function createdatapasien()
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.createdatapasien');
        } else {
            return view('errrors.403');
        }
    }

    public function storedatapasien(Request $request)
    {
        if (Auth::user()->role == 'admin') {

            $request->validate([
                'photo_pasien' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4980',
            ]);
            
            try {
                $cekdata1 = DB::connection('mysql')
                ->table(DB::raw("(select count(*) jml from users where username = '$request->nik_pasien')x"))->first();

                if ($cekdata1->jml > 0) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data Gagal diSimpan!, Karena: NIK sudah terdaftar"
                    ]);
                    return redirect()->route('admin.createdatapasien');
                } else {

                    $cekdata2 = DB::connection('mysql')
                    ->table(DB::raw("(select count(*) jml from users where email = '$request->email_pasien')x"))->first();

                    if ($cekdata2->jml > 0) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data Gagal diSimpan!, Karena: Email sudah terdaftar"
                        ]);
                        return redirect()->route('admin.createdatapasien');
                    } else {
                        DB::beginTransaction();

                        if ($request->hasFile('photo_pasien')) {
                            $image = $request->file('photo_pasien'); 
                            $destinationPath = public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'photo';
                            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                            $image->move($destinationPath, $profileImage);
                            $photo_pasien = "$profileImage";
                        } else {
                            $photo_pasien = null;
                        }

                        Pasien::create([
                            'email_pasien' => $request->email_pasien,
                            'nik_pasien' => $request->nik_pasien,
                            'nm_pasien' => $request->nm_pasien,
                            'tmp_lah_pasien' => $request->tmp_lah_pasien,
                            'tgl_lah_pasien' => $request->tgl_lah_pasien,
                            'jen_kel_pasien' => $request->jen_kel_pasien,
                            'alamat_pasien' => $request->alamat_pasien,
                            'no_hp_pasien' => $request->no_hp_pasien,
                            'photo_pasien' => $photo_pasien,
                        ]);

                        User::create([
                            'name' => $request->nm_pasien,
                            'username' => $request->nik_pasien,
                            'email' => $request->email_pasien,
                            'role' => 'pasien',
                            'password' => Hash::make($request->password),
                        ]);
                        
                        DB::commit();
                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Data Berhasil diSimpan!"
                        ]);
                        return redirect()->route('admin.indexdatapasien');
                    }

                }

            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);
                return redirect()->route('admin.createdatapasien');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function deletedatapasien(Request $request, $nik_pasien) 
    {
        if (Auth::user()->role == 'admin') {
            try {
                $nik_pasien = base64_decode($nik_pasien);

                $photo = Pasien::select('photo_pasien')->where('nik_pasien',$nik_pasien)->first();
                if ($photo != null) {
                    $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'photo' . DIRECTORY_SEPARATOR . $photo->photo_pasien;
                    if(File::exists($destinationPath)) {
                        File::delete($destinationPath);
                    }
                }

                DB::beginTransaction();

                DB::connection('mysql')
                ->table('users')
                ->where('username', $nik_pasien)
                ->delete();

                DB::connection('mysql')
                ->table('pasiens')
                ->where('nik_pasien', $nik_pasien)
                ->delete();

                DB::commit();
                return response()->json(['indctr' => '1', 'msg' => 'Data Berhasil diHapus!']);
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['indctr' => '0', 'msg' => 'Karena: '.$e]);
            }
        } else {
            return view('errrors.403');
        }
    }

    public function editdatapasien(Request $request, $nik)
    {
        if (Auth::user()->role == 'admin') {
            $datapasien = DB::connection('mysql')
            ->table('pasiens')
            ->where('nik_pasien', base64_decode($nik))
            ->first();

            return view('admin.editdatapasien')->with(compact('datapasien'));
        } else {
            return view('errrors.403');
        }
    }


    public function updatedatapasien(Request $request, $nik)
    {
        if (Auth::user()->role == 'admin') {

            $request->validate([
                'photo_pasien' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4980',
            ]);

            try {

                $nik = base64_decode($nik);

                $username = Pasien::select('*')->where('nik_pasien',$nik)->first();
                $photo_lama = $username->photo_pasien;


                if ($request->hasFile('photo_pasien')) {
                    $image = $request->file('photo_pasien'); 
                    $destinationPath = public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'photo';
                    $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                    $photo_pasien = "$profileImage";

                    //hapus photolama
                    if ($photo_lama != null) {
                        $photopath = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'photo' . DIRECTORY_SEPARATOR . $photo_lama;
                        if(File::exists($photopath)) {
                            File::delete($photopath);
                        }                        
                    }
                } else {
                    $photo_pasien = $photo_lama;
                }

                DB::beginTransaction();

                Pasien::where('nik_pasien',$nik)
                ->update([
                    'nm_pasien' => $request->nm_pasien,
                    'tmp_lah_pasien' => $request->tmp_lah_pasien,
                    'tgl_lah_pasien' => $request->tgl_lah_pasien,
                    'no_hp_pasien' => $request->no_hp_pasien,
                    'jen_kel_pasien' => $request->jen_kel_pasien,
                    'alamat_pasien' => $request->alamat_pasien,
                    'photo_pasien' => $photo_pasien,
                ]);

                User::where('username',$nik)
                ->update([
                    'name' => $request->nm_pasien,
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil diUbah!"
                ]);
                return redirect()->route('admin.indexdatapasien');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);

                $datapasien = DB::connection('mysql')
                ->table('pasiens')
                ->where('nik_pasien', base64_decode($nik))
                ->first();

                return view('admin.editdatapasien')->with(compact('datapasien'));
            }
        } else {
            return view('errrors.403');
        }        
    }

    public function indexabsensi(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.indexabsensi');
        } else {
            return view('errrors.403');
        }
    }

    public function dashboardabsensi(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            if ($request->ajax()) {
                $list = DB::connection('mysql')
                ->table(DB::raw("(select *, coalesce((select nm_dokter from dokters where absensis.id_dokter = dokters.id_dokter),'-') nm_dokter from absensis)x"));

                return DataTables::of($list)
                ->editColumn('kehadiran', function($lists){
                    if ($lists->kehadiran == 'y') {
                        $status = "<span class='btn btn-success btn-sm' style='padding:5px'>Hadir</span>";
                    } else {
                        $status = "<span class='btn btn-danger btn-sm' style='padding:5px'>Tidak</span>";
                    }
                    return $status;
                })
                ->rawColumns(['kehadiran','action'])
                ->editColumn('action', function($lists){
                    return "<span class='btn btn-success btn-xs' title='Edit Data' onclick='editabsen(\"".base64_encode($lists->id_absen)."\")'><i class='fas fa-edit'></i> </span>";
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function cetakabsensi(Request $request, $tgl_awal, $tgl_akhir)
    {
        if (Auth::user()->role == 'admin') {
            $tgl_awal = base64_decode($tgl_awal);
            $tgl_akhir = base64_decode($tgl_akhir);
            try {

                $data['query'] = DB::connection('mysql')
                ->table(DB::raw("(select *, (select nm_dokter from dokters where absensis.id_dokter = dokters.id_dokter) nm_dokter from absensis where date_format(tgl_absen,'%Y-%m-%d') >= date_format('$tgl_awal','%Y-%m-%d') and date_format(tgl_absen,'%Y-%m-%d') <= date_format('$tgl_akhir','%Y-%m-%d'))x"))->get();
                $data['tgl_awal'] = $tgl_awal;
                $data['tgl_akhir'] = $tgl_akhir;

                $pdf = PDF::loadView('admin.pdf.absensi',compact('data'));
                
                return $pdf->download('absensi.pdf');
            } catch (Exception $ex) {
                return $ex;
            }
        } else {
            return view('errors.403');
        }
    }

    public function getdataabsensi(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {
            try {
                $id = base64_decode($id);
                $indctr = 1;
                $data = DB::connection('mysql')
                ->table(DB::raw("(select *, (select nm_dokter from dokters where absensis.id_dokter = dokters.id_dokter) nm_dokter from absensis where id_absen = '$id')x"))
                ->first();
                return response()->json(['indctr' => $indctr, 'data' => $data]);
            } catch (Exception $e) {
                $indctr = 0;
                return response()->json(['indctr' => $indctr, 'data' => $e]);
            }
        } else {
            return view('errors.403');
        }
    }

    public function updateabsen(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            try {
                $indctr = 1; 
                DB::beginTransaction();

                DB::connection('mysql')
                ->table('absensis')
                ->where('id_absen',$request->id_absen)
                ->update([
                    'tgl_absen' => $request->tgl_absen,
                    'jam_masuk' => $request->jam_masuk,
                    'jam_keluar' => $request->jam_keluar,
                    'kehadiran' => $request->kehadiran,
                    'updated_at' => Carbon::now(),
                ]);

                DB::commit();
                return response()->json(['indctr' => $indctr, 'msg' => 'Berhasil DiUbah!']);
            } catch (Exception $e) {
                DB::rollback();
                $indctr = 0;
                return response()->json(['indctr' => $indctr, 'msg' => $e]);
            }
        } else {
            return view('errors.403');
        }  
    }

    public function indexjadwaldokter(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $datadokter = Dokter::select('*')->get();
            return view('admin.indexjadwaldokter')->with(compact('datadokter'));
        } else {
            return view('errrors.403');
        }
    }

    public function dashboardjadwaldokter(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            if ($request->ajax()) {
                $list = DB::connection('mysql')
                ->table(DB::raw("(select *, coalesce((select nm_dokter from dokters where jadwal_dokters.id_dokter = dokters.id_dokter),'-') nm_dokter from jadwal_dokters)x"));

                return DataTables::of($list)
                ->editColumn('jadwal_dokter', function($lists){
                    $senin = $lists->senin == 't' ? "class='btn btn-sm btn-success' title='Masuk'" : "class='btn btn-sm btn-danger' title='Tidak Masuk'";
                    $selasa = $lists->selasa == 't' ? "class='btn btn-sm btn-success' title='Masuk'" : "class='btn btn-sm btn-danger' title='Tidak Masuk'";
                    $rabu = $lists->rabu == 't' ? "class='btn btn-sm btn-success' title='Masuk'" : "class='btn btn-sm btn-danger' title='Tidak Masuk'";
                    $kamis = $lists->kamis == 't' ? "class='btn btn-sm btn-success' title='Masuk'" : "class='btn btn-sm btn-danger' title='Tidak Masuk'";
                    $jumat = $lists->jumat == 't' ? "class='btn btn-sm btn-success' title='Masuk'" : "class='btn btn-sm btn-danger' title='Tidak Masuk'";

                    return "<span $senin style='padding:5px;'>Senin</span> <span $selasa style='padding:5px;'>Selasa</span> <span $rabu style='padding:5px;'>Rabu</span> <span $kamis style='padding:5px;'>Kamis</span> <span $jumat style='padding:5px;'>Jum'at</span>";
                })
                ->rawColumns(['jadwal_dokter','action'])
                ->editColumn('action', function($lists){
                    return "<span class='btn btn-success btn-xs' title='Edit Data' onclick='editjadwal(\"".base64_encode($lists->id_jadwal)."\")'><i class='fas fa-edit'></i> </span> <span class='btn btn-danger btn-xs' title='Hapus Data' onclick='hapusdata(\"".base64_encode($lists->id_jadwal)."\")'><i class='fas fa-trash'></i> </span>";
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function storejadwaldokter(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            if ($request->ajax()) {
                try {
                    if ($request->id_dokter == '') {
                        $indctr = 0;
                        return response()->json(['indctr' => $indctr, 'msg' => 'Harap Pilih Dokter terlebih dahulu!']);
                    } else {
                        $senin = in_array('senin', $request->hari) ? 't' : 'f';
                        $selasa = in_array('selasa', $request->hari) ? 't' : 'f';
                        $rabu = in_array('rabu', $request->hari) ? 't' : 'f';
                        $kamis = in_array('kamis', $request->hari) ? 't' : 'f';
                        $jumat = in_array('jumat', $request->hari) ? 't' : 'f';

                        $cekdata = DB::connection('mysql')
                        ->table(DB::raw("(select count(*) jml from jadwal_dokters where id_dokter = '$request->id_dokter')x"))->first();

                        if ($cekdata->jml > 0) {
                            $indctr = 0;
                            return response()->json(['indctr' => $indctr, 'msg' => 'Dokter sudah terjadwalkan!']);
                        } else {
                            DB::beginTransaction();
                            DB::connection('mysql')
                            ->table('jadwal_dokters')
                            ->insert([
                                'id_dokter' => $request->id_dokter,
                                'senin' => $senin,
                                'selasa' => $selasa,
                                'rabu' => $rabu,
                                'kamis' => $kamis,
                                'jumat' => $jumat,
                                'ket_jadwal' => $request->ket_jadwal,
                                'created_at' => Carbon::now(),
                            ]);
                            DB::commit();
                            return response()->json(['indctr' => 1, 'msg' => 'Berhasil DiSimpan!']);
                        }
                    }
                } catch (Exception $e) {
                    DB::rollback();
                    $indctr = 0;
                    return response()->json(['indctr' => $indctr, 'msg' => $e]);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function getdatajadwal(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {
            try {
                $id = base64_decode($id);
                $indctr = 1;
                $data = DB::connection('mysql')
                ->table(DB::raw("(select *, coalesce((select nm_dokter from dokters where jadwal_dokters.id_dokter = dokters.id_dokter),'-') nm_dokter from jadwal_dokters where id_jadwal = '$id')x"))
                ->first();
                return response()->json(['indctr' => $indctr, 'data' => $data]);
            } catch (Exception $e) {
                $indctr = 0;
                return response()->json(['indctr' => $indctr, 'data' => $e]);
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatejadwal(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            try {
                $indctr = 1; 
                $senin = in_array('senin', $request->hari) ? 't' : 'f';
                $selasa = in_array('selasa', $request->hari) ? 't' : 'f';
                $rabu = in_array('rabu', $request->hari) ? 't' : 'f';
                $kamis = in_array('kamis', $request->hari) ? 't' : 'f';
                $jumat = in_array('jumat', $request->hari) ? 't' : 'f';
                DB::beginTransaction();

                DB::connection('mysql')
                ->table('jadwal_dokters')
                ->where('id_jadwal',$request->id_jadwal)
                ->update([
                    'senin' => $senin,
                    'selasa' => $selasa,
                    'rabu' => $rabu,
                    'kamis' => $kamis,
                    'jumat' => $jumat,
                    'ket_jadwal' => $request->ket_jadwal,
                    'updated_at' => Carbon::now(),
                ]);

                DB::commit();
                return response()->json(['indctr' => $indctr, 'msg' => 'Berhasil DiUbah!']);
            } catch (Exception $e) {
                DB::rollback();
                $indctr = 0;
                return response()->json(['indctr' => $indctr, 'msg' => $e]);
            }
        } else {
            return view('errors.403');
        }  
    }

    public function deletejadwal(Request $request, $id_jadwal) 
    {
        if (Auth::user()->role == 'admin') {
            try {
                $id_jadwal = base64_decode($id_jadwal);

                DB::beginTransaction();

                DB::connection('mysql')
                ->table('jadwal_dokters')
                ->where('id_jadwal', $id_jadwal)
                ->delete();

                DB::commit();
                return response()->json(['indctr' => '1', 'msg' => 'Data Berhasil diHapus!']);
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['indctr' => '0', 'msg' => 'Karena: '.$e]);
            }
        } else {
            return view('errrors.403');
        }
    }

    public function editprofile()
    {
        if (Auth::user()->role == 'admin') {
            $data = DB::connection('mysql')
            ->table('admins')
            ->where('username', Auth::user()->username)
            ->first();
            return view('admin.editprofile')->with(compact('data'));
        } else {
            return view('errors.403');
        }
    }

    public function updateprofile(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {

            $request->validate([
                'photo_admin' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4980',
            ]);

            try {
                $username = Admin::select('*')->where('id_admin',$request->id_admin)->first();
                $photo_lama = $username->photo_admin;


                if ($request->hasFile('photo_admin')) {
                    $image = $request->file('photo_admin'); 
                    $destinationPath = public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'photo';
                    $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                    $photo_admin = "$profileImage";

                    //hapus photolama
                    if ($photo_lama != null) {
                        $photopath = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'photo' . DIRECTORY_SEPARATOR . $photo_lama;
                        if(File::exists($photopath)) {
                            File::delete($photopath);
                        }                        
                    }
                } else {
                    $photo_admin = $photo_lama;
                }

                DB::beginTransaction();

                Admin::where('id_admin',$request->id_admin)
                ->update([
                    'nm_admin' => $request->nm_admin,
                    'email_admin' => $request->email_admin,
                    'username' => $request->username,
                    'tmp_lah_admin' => $request->tmp_lah_admin,
                    'tgl_lah_admin' => $request->tgl_lah_admin,
                    'no_hp_admin' => $request->no_hp_admin,
                    'jen_kel_admin' => $request->jen_kel_admin,
                    'photo_admin' => $photo_admin,
                ]);

                User::where('username',$request->username)
                ->update([
                    'name' => $request->nm_admin,
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil diUbah!, Mohon untuk melakukan login ulang."
                ]);

                return redirect()->route('admin.editprofile');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);

                return redirect()->route('admin.editprofile');
            }
        } else {
            return view('errrors.403');
        }        
    }

    public function indexpembayaran()
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.indexpembayaran');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardpembayaran(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            if ($request->ajax()) {

                $list = DB::connection('mysql')
                ->table(DB::raw("(select pembayarans.photo_pembayaran, pembayarans.tgl_pembayaran, pembayarans.st_pembayaran, pemeriksaans.id_dokter, (select nm_dokter from dokters where dokters.id_dokter = pemeriksaans.id_dokter) nm_dokter, pendaftarans.nm_hewan, pendaftarans.jenis_hewan, (select nm_pasien from pasiens where pendaftarans.nik_pasien = pasiens.nik_pasien) nm_pasien, pemeriksaans.tgl_pemeriksaan, pembayarans.id_pembayaran,pemeriksaans.id_pemeriksaan, pemeriksaans.harga_pemeriksaan from pembayarans join pemeriksaans on pemeriksaans.id_pemeriksaan = pembayarans.id_pemeriksaan join pendaftarans on pendaftarans.id_pendaftaran = pemeriksaans.id_pendaftaran)x"));

                return DataTables::of($list)
                ->editColumn('st_pembayaran', function($lists){
                    if ($lists->st_pembayaran == '1') {
                        $status = 'Menunggu Pembayaran';
                    }elseif($lists->st_pembayaran == '2') {
                        $status = 'Menunggu Approval Admin';
                    }else {
                        $status = 'Selesai';
                    }
                    return $status;
                })
                ->editColumn('total_tagihan', function($lists){
                    $hrg = 0;
                    $ttlhrg = 0;
                    $dataobat = DB::connection('mysql')
                    ->table(DB::raw("(select *, (select harga_obat from resep_obats where detail_pemeriksaans.id_obat = resep_obats.id_obat)harga_obat from detail_pemeriksaans where id_pemeriksaan = '$lists->id_pemeriksaan')x"))->get();
                    if (isset($dataobat)) {
                        foreach ($dataobat as $key => $value) {
                            $hrg += intval($value->harga_obat) * intval($value->jml_obat);
                        }
                    }
                    $ttlhrg = $hrg + $lists->harga_pemeriksaan;
                    return 'Rp. '.$ttlhrg.',00.-';
                })
                ->editColumn('photo_pembayaran', function($lists){
                    if ($lists->photo_pembayaran != null) {
                        $img = "<img src='".asset('images/photo/'.$lists->photo_pembayaran)."' style='width:70px;height:40px;' alt='Bukti Pembayaran'>";
                    } else {
                        $img = '-';
                    }
                    return $img;
                })
                ->editColumn('action', function($lists){
                    if ($lists->st_pembayaran == '2') {
                        $action = "<a href='".route('admin.createpembayaran',base64_encode($lists->id_pembayaran))."'><span class='btn btn-success btn-xs' title='Approval Pembayaran'><i class='fas fa-check'></i> </span>";
                    } elseif($lists->st_pembayaran == '3') {
                        $action =  "<span class='btn btn-info btn-xs' title='Cetak Struk Pembayaran' onclick='cetakstruk(\"".base64_encode($lists->id_pembayaran)."\")'><i class='fas fa-print'></i> </span>";

                    } else {
                        $action = '-';
                    }
                    return $action;
                })
                ->rawColumns(['st_pembayaran','action','photo_pembayaran'])
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function createpembayaran(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {
            $id = base64_decode($id);

            $datapembayaran = DB::connection('mysql')
            ->table(DB::raw("(select pembayarans.photo_pembayaran, pembayarans.tgl_pembayaran, pembayarans.st_pembayaran, pemeriksaans.id_dokter, (select nm_dokter from dokters where dokters.id_dokter = pemeriksaans.id_dokter) nm_dokter, pendaftarans.id_pendaftaran, pendaftarans.nm_hewan, pendaftarans.jenis_hewan, pemeriksaans.tgl_pemeriksaan, pembayarans.id_pembayaran,pemeriksaans.id_pemeriksaan, pemeriksaans.harga_pemeriksaan from pembayarans join pemeriksaans on pemeriksaans.id_pemeriksaan = pembayarans.id_pemeriksaan join pendaftarans on pendaftarans.id_pendaftaran = pemeriksaans.id_pendaftaran where pembayarans.id_pembayaran = '$id')x"))->first();

            $hrg = 0;
            $ttlhrg = 0;
            $dataobat = DB::connection('mysql')
            ->table(DB::raw("(select *, (select harga_obat from resep_obats where detail_pemeriksaans.id_obat = resep_obats.id_obat)harga_obat from detail_pemeriksaans where id_pemeriksaan = '$datapembayaran->id_pemeriksaan')x"))->get();
            if (isset($dataobat)) {
                foreach ($dataobat as $key => $value) {
                    $hrg += intval($value->harga_obat) * intval($value->jml_obat);
                }
            }
            $ttlhrg = $hrg + $datapembayaran->harga_pemeriksaan;

            return view('admin.createpembayaran')->with(compact('datapembayaran','ttlhrg'));
        } else {
            return view('errrors.403');
        }
    }

    public function storepembayaran(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            try {
                $idadmin = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);

                DB::beginTransaction();
                DB::connection('mysql')
                ->table('pembayarans')
                ->where('id_pembayaran', $request->id_pembayaran)
                ->update([
                    'id_admin' => $idadmin->id_admin,
                    'uang_bayar' => $request->uang_bayar,
                    'uang_kembalian' => $request->uang_kembali,
                    'ket_pembayaran' => $request->ket_pembayaran,
                    'st_pembayaran' => 3,
                    'updated_at' => Carbon::now()
                ]);

                DB::connection('mysql')
                ->table('pendaftarans')
                ->where('id_pendaftaran', $request->id_pendaftaran)
                ->update([
                    'st_pendaftarans' => 3,
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil diSimpan!"
                ]);
                return redirect()->route('admin.indexpembayaran');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);
                return redirect()->route('admin.createpembayaran');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function tolakpembayaran(Request $request, $id) 
    {
        if (Auth::user()->role == 'admin') {
            try {
                $id = base64_decode($id);

                DB::beginTransaction();

                DB::connection('mysql')
                ->table('pembayarans')
                ->where('id_pembayaran', $id)
                ->update([
                    'st_pembayaran' => 1,
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return response()->json(['indctr' => '1', 'msg' => 'Pembayaran Berhasil Ditolak!']);
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['indctr' => '0', 'msg' => 'Karena: '.$e]);
            }
        } else {
            return view('errrors.403');
        }
    }

    public function cetakstruk(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {
            $id = base64_decode($id);
            try {                
                $data = DB::connection('mysql')
                ->table(DB::raw("(select (select nm_admin from admins where admins.id_admin = pembayarans.id_admin) nm_admin, pembayarans.tgl_pembayaran, pembayarans.st_pembayaran, pembayarans.uang_bayar, pembayarans.uang_kembalian, pemeriksaans.id_dokter, (select nm_dokter from dokters where dokters.id_dokter = pemeriksaans.id_dokter) nm_dokter, pendaftarans.id_pendaftaran, pendaftarans.nm_hewan, pendaftarans.jenis_hewan, pemeriksaans.tgl_pemeriksaan, pembayarans.id_pembayaran,pemeriksaans.id_pemeriksaan, pemeriksaans.harga_pemeriksaan from pembayarans join pemeriksaans on pemeriksaans.id_pemeriksaan = pembayarans.id_pemeriksaan join pendaftarans on pendaftarans.id_pendaftaran = pemeriksaans.id_pendaftaran where pembayarans.id_pembayaran = '$id')x"))->first();

                $hrg = 0;
                $ttlhrg = 0;
                $dataobat = DB::connection('mysql')
                ->table(DB::raw("(select *, (select harga_obat from resep_obats where detail_pemeriksaans.id_obat = resep_obats.id_obat) harga_obat, (select nm_obat from resep_obats where detail_pemeriksaans.id_obat = resep_obats.id_obat) nm_obat from detail_pemeriksaans where id_pemeriksaan = '$data->id_pemeriksaan')x"))->get();
                if (isset($dataobat)) {
                    foreach ($dataobat as $key => $value) {
                        $hrg += intval($value->harga_obat) * intval($value->jml_obat);
                    }
                }
                $ttlhrg = $hrg + $data->harga_pemeriksaan;
                
                $pdf = PDF::loadView('admin.pdf.strukpembayaran',compact('data','dataobat','ttlhrg'))->setPaper('a4', 'portrait');
                
                return $pdf->download('struk_pembayaran.pdf');
            } catch (Exception $ex) {
                return $ex;
            }
        } else {
            return view('errors.403');
        }
    }    
}
