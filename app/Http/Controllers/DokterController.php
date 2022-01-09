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

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'dokter') {
            $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);

            $datapendaftaran = DB::connection('mysql')
            ->table(DB::raw("(select coalesce(count(*),0) jml from pendaftarans where date_format(tgl_pendaftaran,'%Y-%m-%d') = date_format(sysdate(),'%Y-%m-%d')) x"))->first();
            $datapemeriksaan = DB::connection('mysql')
            ->table(DB::raw("(select coalesce(count(*),0) jml from pemeriksaans where date_format(tgl_pemeriksaan,'%Y-%m-%d') = date_format(sysdate(),'%Y-%m-%d') and id_dokter = '$iddokter->id_dokter') x"))->first();
            return view('dokter.home')->with(compact('datapendaftaran','datapemeriksaan'));
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

    public function indexjadwaldokter(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            $datadokter = Dokter::select('*')->get();
            return view('dokter.indexjadwaldokter')->with(compact('datadokter'));
        } else {
            return view('errrors.403');
        }
    }

    public function dashboardjadwaldokter(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            if ($request->ajax()) {
                $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);

                $list = DB::connection('mysql')
                ->table(DB::raw("(select *, coalesce((select nm_dokter from dokters where jadwal_dokters.id_dokter = dokters.id_dokter),'-') nm_dokter from jadwal_dokters where id_dokter = '$iddokter->id_dokter')x"));

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
                    return "<span class='btn btn-success btn-xs' title='Edit Data' onclick='editjadwal(\"".base64_encode($lists->id_jadwal)."\")'><i class='fas fa-edit'></i> </span>";
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function getdatajadwal(Request $request, $id)
    {
        if (Auth::user()->role == 'dokter') {
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
        if (Auth::user()->role == 'dokter') {
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

    public function indexabsensi(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);
            $getabsensi1 = DB::connection('mysql')
            ->table(DB::raw("(select count(*) jml from absensis where date_format(tgl_absen, '%Y-%m-%d') = date_format(sysdate(), '%Y-%m-%d') and id_dokter = '$iddokter->id_dokter' and kehadiran = 't' and jam_keluar is null)x"))
            ->first();
            $getabsensi2 = DB::connection('mysql')
            ->table(DB::raw("(select count(*) jml from absensis where date_format(tgl_absen, '%Y-%m-%d') = date_format(sysdate(), '%Y-%m-%d') and id_dokter = '$iddokter->id_dokter' and kehadiran = 'y' and jam_keluar is null)x"))
            ->first();
            return view('dokter.indexabsensi')->with(compact('getabsensi1','getabsensi2'));  
        } else {
            return view('errors.403');
        }
    }

    public function dashboardabsensi(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            if ($request->ajax()) {
                $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);

                $list = DB::connection('mysql')
                ->table(DB::raw("(select *, coalesce((select nm_dokter from dokters where absensis.id_dokter = dokters.id_dokter),'-') nm_dokter from absensis where id_dokter = '$iddokter->id_dokter')x"));

                return DataTables::of($list)
                ->editColumn('kehadiran', function($lists){
                    if ($lists->kehadiran == 'y') {
                        $status = "<span class='btn btn-success btn-sm' style='padding:5px'>Hadir</span>";
                    } else {
                        $status = "<span class='btn btn-danger btn-sm' style='padding:5px'>Tidak</span>";
                    }
                    return $status;
                })
                ->rawColumns(['kehadiran'])
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
        if (Auth::user()->role == 'dokter') {
            $tgl_awal = base64_decode($tgl_awal);
            $tgl_akhir = base64_decode($tgl_akhir);
            $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);
            try {

                $data['query'] = DB::connection('mysql')
                ->table(DB::raw("(select *, (select nm_dokter from dokters where absensis.id_dokter = dokters.id_dokter) nm_dokter from absensis where date_format(tgl_absen,'%Y-%m-%d') >= date_format('$tgl_awal','%Y-%m-%d') and date_format(tgl_absen,'%Y-%m-%d') <= date_format('$tgl_akhir','%Y-%m-%d') and id_dokter = '$iddokter->id_dokter')x"))->get();
                $data['tgl_awal'] = $tgl_awal;
                $data['tgl_akhir'] = $tgl_akhir;

                $pdf = PDF::loadView('dokter.pdf.absensi',compact('data'));
                
                return $pdf->download('absensi.pdf');
            } catch (Exception $ex) {
                return $ex;
            }
        } else {
            return view('errors.403');
        }
    }

    public function absenmasuk(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);
            try {
                $indctr = 1;
                DB::beginTransaction();

                DB::connection('mysql')
                ->table('absensis')
                ->insert([
                    'id_dokter' => $iddokter->id_dokter,
                    'tgl_absen' => Carbon::now(),
                    'kehadiran' => 'y',
                    'jam_masuk' => Carbon::now()->format('H:i'),
                    'created_at' => Carbon::now()
                ]);

                DB::commit();
                return response()->json(['indctr' => $indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $indctr = 0;
                return response()->json(['indctr' => $indctr]);
            }
        } else {
            return view('errors.403');
        }
    }

    public function absenkeluar(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);
            try {
                $indctr = 1;
                DB::beginTransaction();

                DB::connection('mysql')
                ->table('absensis')
                ->where('id_dokter',$iddokter->id_dokter)
                ->whereRaw("date_format(tgl_absen,'%Y-%m-%d') = date_format(sysdate(),'%Y-%m-%d')")
                ->update([
                    'kehadiran' => 'y',
                    'jam_keluar' => Carbon::now()->format('H:i'),
                    'updated_at' => Carbon::now()
                ]);
                 
                DB::commit();
                return response()->json(['indctr' => $indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $indctr = 0;
                return response()->json(['indctr' => $indctr]);
            }
        } else {
            return view('errors.403');
        }
    }

    public function editprofile()
    {
        if (Auth::user()->role == 'dokter') {
            $data = DB::connection('mysql')
            ->table('dokters')
            ->where('username', Auth::user()->username)
            ->first();
            return view('dokter.editprofile')->with(compact('data'));
        } else {
            return view('errors.403');
        }
    }

    public function updateprofile(Request $request, $id)
    {
        if (Auth::user()->role == 'dokter') {

            $request->validate([
                'photo_dokter' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4980',
            ]);

            try {
                $username = Dokter::select('*')->where('id_dokter',$request->id_dokter)->first();
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

                Dokter::where('id_dokter',$request->id_dokter)
                ->update([
                    'nm_dokter' => $request->nm_dokter,
                    'email_dokter' => $request->email_dokter,
                    'username' => $request->username,
                    'tmp_lah_dokter' => $request->tmp_lah_dokter,
                    'tgl_lah_dokter' => $request->tgl_lah_dokter,
                    'no_hp_dokter' => $request->no_hp_dokter,
                    'jen_kel_dokter' => $request->jen_kel_dokter,
                    'photo_dokter' => $photo_dokter,
                ]);

                User::where('username',$request->username)
                ->update([
                    'name' => $request->nm_dokter,
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil diUbah!, Mohon untuk melakukan login ulang."
                ]);

                return redirect()->route('dokter.editprofile');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);

                return redirect()->route('dokter.editprofile');
            }
        } else {
            return view('errrors.403');
        }        
    }

    public function indexresepobat()
    {
        if (Auth::user()->role == 'dokter') {
            return view('dokter.indexresepobat');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardresepobat(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            if ($request->ajax()) {
                $list = DB::connection('mysql')
                ->table(DB::raw("(select * from resep_obats)x"));

                return DataTables::of($list)
                ->rawColumns(['action'])
                ->editColumn('action', function($lists){
                    return "<span class='btn btn-success btn-xs' title='Edit Data' onclick='editdata(\"".base64_encode($lists->id_obat)."\")'><i class='fas fa-edit'></i> </span> <span class='btn btn-danger btn-xs' title='Hapus Data' onclick='hapusdata(\"".base64_encode($lists->id_obat)."\")'><i class='fas fa-trash'></i> </span>";
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function storeresepobat(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            if ($request->ajax()) {
                try {
                    $cekdata = DB::connection('mysql')
                    ->table(DB::raw("(select count(*) jml from resep_obats where nm_obat = '$request->nm_obat')x"))->first();

                    if ($cekdata->jml > 0) {
                        $indctr = 0;
                        return response()->json(['indctr' => $indctr, 'msg' => 'Obat sudah ada!']);
                    } else {
                        DB::beginTransaction();
                        DB::connection('mysql')
                        ->table('resep_obats')
                        ->insert([
                            'nm_obat' => $request->nm_obat,
                            'harga_obat' => $request->harga_obat,
                            'created_at' => Carbon::now(),
                        ]);
                        DB::commit();
                        return response()->json(['indctr' => 1, 'msg' => 'Berhasil DiSimpan!']);
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

    public function getresepobat(Request $request, $id)
    {
        if (Auth::user()->role == 'dokter') {
            try {
                $id = base64_decode($id);
                $indctr = 1;
                $data = DB::connection('mysql')
                ->table(DB::raw("(select * from resep_obats where id_obat = '$id')x"))
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

    public function updateresepobat(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            try {
                $indctr = 1; 
                DB::beginTransaction();

                DB::connection('mysql')
                ->table('resep_obats')
                ->where('id_obat',$request->id_obat)
                ->update([
                    'nm_obat' => $request->nm_obat,
                    'harga_obat' => $request->harga_obat,
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

    public function deleteresepobat(Request $request, $id_obat) 
    {
        if (Auth::user()->role == 'dokter') {
            try {
                $id_obat = base64_decode($id_obat);

                DB::beginTransaction();

                DB::connection('mysql')
                ->table('resep_obats')
                ->where('id_obat', $id_obat)
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

    public function indexpemeriksaan()
    {
        if (Auth::user()->role == 'dokter') {
            return view('dokter.indexpemeriksaan');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardpemeriksaan1(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            if ($request->ajax()) {

                $list = DB::connection('mysql')
                ->table(DB::raw("(select * from pendaftarans where st_pendaftarans = '1')x"));

                return DataTables::of($list)
                ->editColumn('action', function($lists){
                    return "<span class='btn btn-success btn-xs' title='Edit Data' onclick='window.open(\"".route('dokter.createpemeriksaan',base64_encode($lists->id_pendaftaran))."\")'><i class='fas fa-edit'></i> </span> <span onclick='window.open(\"".route('dokter.createrujukan',base64_encode($lists->id_pendaftaran))."\")' class='btn btn-info btn-xs' title='Rujuk Pasien'><i class='fas fa-ambulance'></i> </span>";
                })
                ->rawColumns(['action'])
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function createpemeriksaan(Request $request, $id)
    {
        if (Auth::user()->role == 'dokter') {
            $datapendaftaran = DB::connection('mysql')
            ->table('pendaftarans')
            ->where('id_pendaftaran', base64_decode($id))
            ->first();

            $dataobat = DB::connection('mysql')
            ->table('resep_obats')
            ->get();

            return view('dokter.createpemeriksaan')->with(compact('datapendaftaran','dataobat'));
        } else {
            return view('errrors.403');
        }
    }

    public function storepemeriksaan(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            try {
                $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);
                $idpemeriksaan = DB::connection('mysql')
                ->table(DB::raw("(select coalesce(max(id_pemeriksaan),0) + 1 nomor from pemeriksaans)x"))->first();

                DB::beginTransaction();

                DB::connection('mysql')
                ->table('pendaftarans')
                ->where('id_pendaftaran',$request->id_pendaftaran)
                ->update([
                    'st_pendaftarans' => '2',
                    'updated_at' => Carbon::now()
                ]);

                DB::connection('mysql')
                ->table('pemeriksaans')
                ->insert([
                    'id_pemeriksaan' => $idpemeriksaan->nomor,
                    'id_dokter' => $iddokter->id_dokter,
                    'id_pendaftaran' => $request->id_pendaftaran,
                    'diagnosis_pemeriksaan' => $request->diagnosis_pemeriksaan,
                    'tindakan_pemeriksaan' => $request->tindakan_pemeriksaan,
                    'harga_pemeriksaan' => $request->harga_pemeriksaan,
                    'tgl_pemeriksaan' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]);

                if ($request->id_obat[0] != null) {
                    foreach($request->id_obat as $key => $val) {
                        DB::connection('mysql')
                        ->table('detail_pemeriksaans')
                        ->insert([
                            'id_pemeriksaan' => $idpemeriksaan->nomor,
                            'id_obat' => $request->id_obat[$key],
                            'dosis_obat' => $request->dosis_obat[$key] == null ? '-' : $request->dosis_obat[$key],
                            'jml_obat' => $request->jml_obat[$key],
                        ]);
                    }
                }

                if ($request->kontrol == 'y') {
                    DB::connection('mysql')
                    ->table('data_kontrols')
                    ->insert([
                        'id_pemeriksaan' => $idpemeriksaan->nomor,
                        'st_kontrol' => '1',
                        'tgl_kontrol' => Carbon::now()->addDays(7),
                        'created_at' => Carbon::now(),
                    ]);
                }

                $thn = Carbon::now()->format('Y');
                $bln = Carbon::now()->format('n');
                $kode = 'PMB'.'/'.$bln.'/'.$thn.'/';

                $maxdata = DB::connection('mysql')
                ->table(DB::raw("(SELECT max(id_pembayaran) as kd from pembayarans where id_pembayaran like '$kode%') as c"))
                ->first();

                 if (isset($maxdata)){
                    $nocc = (int) substr($maxdata->kd,-4);
                    $nocc++;
                    $kdbaru = $kode.sprintf("%04s",$nocc);
                 } else {
                    $kdbaru = $kode."0001";
                 }


                DB::connection('mysql')
                ->table('pembayarans')
                ->insert([
                    'id_pembayaran' => $kdbaru,
                    'id_pemeriksaan' => $idpemeriksaan->nomor,
                    'st_pembayaran' => '1',
                    'created_at' => Carbon::now(),
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Pemeriksaan berhasil dibuat."
                ]);

                return redirect()->route('dokter.indexpemeriksaan');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);

                return redirect()->route('dokter.createpemeriksaan',base64_encode($request->id_pendaftaran));
            }
        } else {
            return view('errrors.403');
        }
    }

    public function getharga(Request $request, $id)
    {
        if (Auth::user()->role == 'dokter') {
            try {
                $id = base64_decode($id);
                $data = DB::connection('mysql')
                ->table(DB::raw("(select harga_obat from resep_obats where id_obat = '$id')x"))
                ->first();
                return response()->json($data->harga_obat);
            } catch (Exception $e) {
                return response()->json($e);
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardpemeriksaan2(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            if ($request->ajax()) {
                $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);

                $list = DB::connection('mysql')
                ->table(DB::raw("(select pemeriksaans.*, pendaftarans.nm_hewan, pendaftarans.tgl_pendaftaran, pendaftarans.jenis_hewan, pendaftarans.keluhan, pendaftarans.st_pendaftarans from pemeriksaans join pendaftarans on pendaftarans.id_pendaftaran = pemeriksaans.id_pendaftaran where id_dokter = '$iddokter->id_dokter' and pendaftarans.st_pendaftarans != '1')x"));

                return DataTables::of($list)
                ->editColumn('status',function($lists){
                    if ($lists->st_pendaftarans == 2) {
                        $status = 'Menunggu Pembayaran';
                    } else {
                        $status = 'Selesai';
                    }
                    return $status;
                })
                ->editColumn('obat', function($lists){
                    $dataobat = DB::connection('mysql')
                    ->table(DB::raw("(select *, (select nm_obat from resep_obats where detail_pemeriksaans.id_obat = resep_obats.id_obat)nm_obat from detail_pemeriksaans where id_pemeriksaan = '$lists->id_pemeriksaan')x"))->get();
                    if (isset($dataobat)) {
                        $prefix = $obat = ''; 
                        foreach($dataobat as $val) {
                            $obat .= $prefix . $val->nm_obat . ' ' . $val->jml_obat;
                            $prefix = ', '; 
                        }
                    } else {
                        $obat = '-';
                    }
                    return $obat;
                })
                ->rawColumns(['status','obat'])
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }

    public function createrujukan(Request $request, $id)
    {
        if (Auth::user()->role == 'dokter') {
            $datapendaftaran = DB::connection('mysql')
            ->table('pendaftarans')
            ->where('id_pendaftaran', base64_decode($id))
            ->first();

            return view('dokter.createrujukan')->with(compact('datapendaftaran'));
        } else {
            return view('errrors.403');
        }
    }

    public function storerujukan(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            try {

                $thn = Carbon::now()->format('Y');
                $bln = Carbon::now()->format('n');
                $kode = 'TRF'.'/'.$bln.'/'.$thn.'/';

                $maxdata = DB::connection('mysql')
                ->table(DB::raw("(SELECT max(id_rujukan) as kd from rujukans where id_rujukan like '$kode%') as c"))
                ->first();

                 if (isset($maxdata)){
                    $nocc = (int) substr($maxdata->kd,-4);
                    $nocc++;
                    $kdbaru = $kode.sprintf("%04s",$nocc);
                 } else {
                    $kdbaru = $kode."0001";
                 }

                DB::beginTransaction();

                DB::connection('mysql')
                ->table('pendaftarans')
                ->where('id_pendaftaran',$request->id_pendaftaran)
                ->update([
                    'st_pendaftarans' => '3',
                    'updated_at' => Carbon::now()
                ]);

                DB::connection('mysql')
                ->table('rujukans')
                ->where('id_pendaftaran',$request->id_pendaftaran)
                ->insert([
                    'id_rujukan' => $kdbaru,
                    'id_pendaftaran' => $request->id_pendaftaran,
                    'lok_tujuan' => $request->lok_tujuan,
                    'alamat_tujuan' => $request->alamat_tujuan,
                    'ket_rujukan' => $request->ket_rujukan,
                    'tgl_rujukan' => Carbon::now(),
                    'created_at' => Carbon::now()
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Pemeriksaan berhasil dibuat."
                ]);

                return redirect()->route('dokter.indexpemeriksaan');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);

                return redirect()->route('dokter.createrujukan',base64_encode($request->id_pendaftaran));
            }
        } else {
            return view('errrors.403');
        }
    }
    
    public function indexdatakontrol()
    {
        if (Auth::user()->role == 'dokter') {
            return view('dokter.indexdatakontrol');
        } else {
            return view('errors.403');
        }
    }
    
    public function dashboarddatakontrol(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            if ($request->ajax()) {
                $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);

                $list = DB::connection('mysql')
                ->table(DB::raw("(select dk.id_kontrols, dk.tgl_kontrol, dk.tindakan_kontrol, dk.st_kontrol, (select nm_dokter from dokters where pmk.id_dokter = dokters.id_dokter) nm_dokter, pmk.id_dokter, pmk.tgl_pemeriksaan, pmk.diagnosis_pemeriksaan, pmk.tindakan_pemeriksaan, (select nm_pasien from pasiens where pasiens.nik_pasien = pdf.nik_pasien) nm_pasien, pdf.nm_hewan, pdf.jenis_hewan from data_kontrols dk join pemeriksaans pmk on pmk.id_pemeriksaan = dk.id_pemeriksaan join pendaftarans pdf on pdf.id_pendaftaran = pmk.id_pendaftaran where pmk.id_dokter = '$iddokter->id_dokter' )x"));

                return DataTables::of($list)
                ->editColumn('action', function($lists){
                    if($lists->tgl_kontrol == Carbon::now()->format('Y-m-d')){
                        $action =  "<span onclick='window.open(\"".route('dokter.createdatakontrol',base64_encode($lists->id_kontrols))."\")' class='btn btn-success btn-xs' title='Kontrol'><i class='fas fa-hand-holding-medical'></i> </span>";
                    } else {
                        $action = '-';
                    }

                    return $action;
                })
                ->editColumn('st_kontrol', function($lists){
                    if($lists->st_kontrol == '2'){
                        $status =  "Sudah Kontrol";
                    } else {
                        $status = 'Menunggu Kontrol';
                    }

                    return $status;
                })
                ->rawColumns(['action','st_kontrol'])
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errrors.403');
        }
    }
    
    public function createdatakontrol(Request $request, $id)
    {
        if (Auth::user()->role == 'dokter') {
            $id = base64_decode($id);

            $data = DB::connection('mysql')
            ->table(DB::raw("(select dk.id_kontrols, dk.tgl_kontrol, dk.tindakan_kontrol, dk.st_kontrol, (select nm_dokter from dokters where pmk.id_dokter = dokters.id_dokter) nm_dokter, pmk.id_dokter, pmk.tgl_pemeriksaan, pmk.diagnosis_pemeriksaan, pmk.tindakan_pemeriksaan, pmk.id_pemeriksaan, (select nm_pasien from pasiens where pasiens.nik_pasien = pdf.nik_pasien) nm_pasien, pdf.nm_hewan, pdf.jenis_hewan from data_kontrols dk join pemeriksaans pmk on pmk.id_pemeriksaan = dk.id_pemeriksaan join pendaftarans pdf on pdf.id_pendaftaran = pmk.id_pendaftaran where dk.id_kontrols = '$id' )x"))->first();

            return view('dokter.createdatakontrol')
            ->with(compact('data'));
        } else {
            return view('errrors.403');
        }
    }
  
    public function storedatakontrol(Request $request)
    {
        if (Auth::user()->role == 'dokter') {
            try {
                $iddokter = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);
                
                DB::beginTransaction();

                DB::connection('mysql')
                ->table('data_kontrols')
                ->where('id_pemeriksaan', $request->id_pemeriksaan)
                ->where('id_kontrols', $request->id_kontrols)
                ->update([
                    'st_kontrol' => '2',
                    'tindakan_kontrol' => $request->tindakan_kontrol,
                    'tgl_kontrol' => Carbon::now()->addDays(7),
                    'updated_at' => Carbon::now(),
                ]);

                $thn = Carbon::now()->format('Y');
                $bln = Carbon::now()->format('n');
                $kode = 'PMB'.'/'.$bln.'/'.$thn.'/';

                $maxdata = DB::connection('mysql')
                ->table(DB::raw("(SELECT max(id_pembayaran) as kd from pembayarans where id_pembayaran like '$kode%') as c"))
                ->first();

                 if (isset($maxdata)){
                    $nocc = (int) substr($maxdata->kd,-4);
                    $nocc++;
                    $kdbaru = $kode.sprintf("%04s",$nocc);
                 } else {
                    $kdbaru = $kode."0001";
                 }


                DB::connection('mysql')
                ->table('pembayarans')
                ->insert([
                    'id_pembayaran' => $kdbaru,
                    'id_pemeriksaan' => $request->id_pemeriksaan,
                    'st_pembayaran' => '1',
                    'created_at' => Carbon::now(),
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Pemeriksaan berhasil dibuat."
                ]);

                return redirect()->route('dokter.indexdatakontrol');
            } catch (Exception $e) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal diSimpan!, Karena: ".$e
                ]);

                return redirect()->route('dokter.createdatakontrol',base64_encode($request->id_kontrols));
            }
        } else {
            return view('errrors.403');
        }
    }
}
