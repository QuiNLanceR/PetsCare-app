<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// landing page
Route::get('/', function () {
    $dokter = DB::connection('mysql')
    ->table('dokters')
    ->join('jadwal_dokters','jadwal_dokters.id_dokter', '=', 'dokters.id_dokter')
    ->limit(4)
    ->get();
    return view('welcome')->with(compact('dokter'));
})->name('/');

Route::get('/about', function () {
    return view('about');
})->name('/about');

Route::get('/gallery', function () {
    return view('gallery');
})->name('/gallery');

Route::get('/contact', function () {
    return view('contact');
})->name('/contact');

Route::get('/sendmailcontact/{name}/{email}/{pesan}', function($name,$email,$pesan) {
    $name = base64_decode($name);
    $email = base64_decode($email);
    $pesan = base64_decode($pesan);

    \Mail::send('contactMail', array(
        'name' => $name,
        'email' => $email,
        'pesan' => $pesan,
    ), function($message) use ($email){
        $message->from($email);
        $message->to('imbarscout@gmail.com', 'imbarscout123')->subject('Pasien Puskeswan');
    });

    return response()->json('Email berhasil dikirim');
})->name('/sendmailcontact');

// auth
Auth::routes();

//pasien
Route::get('/pasien', 'PasienController@index')->name('pasien')->middleware('pasien');

Route::get('/pasien/editprofile', 'PasienController@editprofile')->name('pasien.editprofile')->middleware('pasien');
Route::post('/pasien/updateprofile/{param}', 'PasienController@updateprofile')->name('pasien.updateprofile')->middleware('pasien');

Route::get('/pasien/indexpemeriksaan', 'PasienController@indexpemeriksaan')->name('pasien.indexpemeriksaan')->middleware('pasien');
Route::get('/pasien/dashboardpendaftaran', 'PasienController@dashboardpendaftaran')->name('pasien.dashboardpendaftaran')->middleware('pasien');
Route::get('/pasien/dashboardpemeriksaan', 'PasienController@dashboardpemeriksaan')->name('pasien.dashboardpemeriksaan')->middleware('pasien');
Route::get('/pasien/createpemeriksaan', 'PasienController@createpemeriksaan')->name('pasien.createpemeriksaan')->middleware('pasien');
Route::post('/pasien/storepemeriksaan', 'PasienController@storepemeriksaan')->name('pasien.storepemeriksaan')->middleware('pasien');
Route::get('/pasien/deletepemeriksaan/{param1}', 'PasienController@deletepemeriksaan')->name('pasien.deletepemeriksaan')->middleware('pasien');
Route::get('/pasien/getpemeriksaan/{param1}', 'PasienController@getpemeriksaan')->name('pasien.getpemeriksaan')->middleware('pasien');
Route::get('/pasien/updatepemeriksaan', 'PasienController@updatepemeriksaan')->name('pasien.updatepemeriksaan')->middleware('pasien');
Route::get('/pasien/indexpembayaran', 'PasienController@indexpembayaran')->name('pasien.indexpembayaran')->middleware('pasien');
Route::get('/pasien/dashboardpembayaran', 'PasienController@dashboardpembayaran')->name('pasien.dashboardpembayaran')->middleware('pasien');
Route::get('/pasien/createpembayaran/{param1}', 'PasienController@createpembayaran')->name('pasien.createpembayaran')->middleware('pasien');
Route::post('/pasien/storepembayaran', 'PasienController@storepembayaran')->name('pasien.storepembayaran')->middleware('pasien');

Route::get('/pasien/cetakrujukan/{param1}', 'PasienController@cetakrujukan')->name('pasien.cetakrujukan')->middleware('pasien');
Route::get('/pasien/cetakstruk/{param1}', 'PasienController@cetakstruk')->name('pasien.cetakstruk')->middleware('pasien');

Route::get('/pasien/indexdatakontrol', 'PasienController@indexdatakontrol')->name('pasien.indexdatakontrol')->middleware('pasien');
Route::get('/pasien/dashboarddatakontrol', 'PasienController@dashboarddatakontrol')->name('pasien.dashboarddatakontrol')->middleware('pasien');


//admin
Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');

Route::get('/admin/datadokter', 'AdminController@indexdatadokter')->name('admin.indexdatadokter')->middleware('admin');
Route::get('/admin/dashboarddatadokter', 'AdminController@dashboarddatadokter')->name('admin.dashboarddatadokter')->middleware('admin');
Route::get('/admin/createdatadokter', 'AdminController@createdatadokter')->name('admin.createdatadokter')->middleware('admin');
Route::post('/admin/storedatadokter', 'AdminController@storedatadokter')->name('admin.storedatadokter')->middleware('admin');
Route::get('/admin/deletedatadokter/{param1}/{param2}', 'AdminController@deletedatadokter')->name('admin.deletedatadokter')->middleware('admin');
Route::get('/admin/editdatadokter/{param1}', 'AdminController@editdatadokter')->name('admin.editdatadokter')->middleware('admin');
Route::put('/admin/updatedatadokter/{param1}', 'AdminController@updatedatadokter')->name('admin.updatedatadokter')->middleware('admin');

Route::get('/admin/datapasien', 'AdminController@indexdatapasien')->name('admin.indexdatapasien')->middleware('admin');
Route::get('/admin/dashboarddatapasien', 'AdminController@dashboarddatapasien')->name('admin.dashboarddatapasien')->middleware('admin');
Route::get('/admin/createdatapasien', 'AdminController@createdatapasien')->name('admin.createdatapasien')->middleware('admin');
Route::post('/admin/storedatapasien', 'AdminController@storedatapasien')->name('admin.storedatapasien')->middleware('admin');
Route::get('/admin/deletedatapasien/{param1}', 'AdminController@deletedatapasien')->name('admin.deletedatapasien')->middleware('admin');
Route::get('/admin/editdatapasien/{param1}', 'AdminController@editdatapasien')->name('admin.editdatapasien')->middleware('admin');
Route::put('/admin/updatedatapasien/{param1}', 'AdminController@updatedatapasien')->name('admin.updatedatapasien')->middleware('admin');

Route::get('/admin/absensi', 'AdminController@indexabsensi')->name('admin.indexabsensi')->middleware('admin');
Route::get('/admin/dashboardabsensi', 'AdminController@dashboardabsensi')->name('admin.dashboardabsensi')->middleware('admin');
Route::get('/admin/cetakabsensi/{param1}/{param2}', 'AdminController@cetakabsensi')->name('admin.cetakabsensi')->middleware('admin');
Route::get('/admin/getdataabsensi/{param1}', 'AdminController@getdataabsensi')->name('admin.getdataabsensi')->middleware('admin');
Route::get('/admin/updateabsen', 'AdminController@updateabsen')->name('admin.updateabsen')->middleware('admin');

Route::get('/admin/jadwaldokter', 'AdminController@indexjadwaldokter')->name('admin.indexjadwaldokter')->middleware('admin');
Route::get('/admin/dashboardjadwaldokter', 'AdminController@dashboardjadwaldokter')->name('admin.dashboardjadwaldokter')->middleware('admin');
Route::post('/admin/storejadwaldokter', 'AdminController@storejadwaldokter')->name('admin.storejadwaldokter')->middleware('admin');
Route::get('/admin/getdatajadwal/{param1}', 'AdminController@getdatajadwal')->name('admin.getdatajadwal')->middleware('admin');
Route::get('/admin/updatejadwal', 'AdminController@updatejadwal')->name('admin.updatejadwal')->middleware('admin');
Route::get('/admin/deletejadwal/{param1}', 'AdminController@deletejadwal')->name('admin.deletejadwal')->middleware('admin');

Route::get('/admin/editprofile', 'AdminController@editprofile')->name('admin.editprofile')->middleware('admin');
Route::post('/admin/updateprofile/{param}', 'AdminController@updateprofile')->name('admin.updateprofile')->middleware('admin');

Route::get('/admin/indexpembayaran', 'AdminController@indexpembayaran')->name('admin.indexpembayaran')->middleware('admin');
Route::get('/admin/dashboardpembayaran', 'AdminController@dashboardpembayaran')->name('admin.dashboardpembayaran')->middleware('admin');
Route::get('/admin/createpembayaran/{param1}', 'AdminController@createpembayaran')->name('admin.createpembayaran')->middleware('admin');
Route::post('/admin/storepembayaran', 'AdminController@storepembayaran')->name('admin.storepembayaran')->middleware('admin');
Route::get('/admin/tolakpembayaran/{param1}', 'AdminController@tolakpembayaran')->name('admin.tolakpembayaran')->middleware('admin');

Route::get('/admin/cetakstruk/{param1}', 'AdminController@cetakstruk')->name('admin.cetakstruk')->middleware('admin');


//dokter
Route::get('/dokter', 'DokterController@index')->name('dokter')->middleware('dokter');

Route::get('/dokter/jadwaldokter', 'DokterController@indexjadwaldokter')->name('dokter.indexjadwaldokter')->middleware('dokter');
Route::get('/dokter/dashboardjadwaldokter', 'DokterController@dashboardjadwaldokter')->name('dokter.dashboardjadwaldokter')->middleware('dokter');
Route::get('/dokter/getdatajadwal/{param1}', 'DokterController@getdatajadwal')->name('dokter.getdatajadwal')->middleware('dokter');
Route::get('/dokter/updatejadwal', 'DokterController@updatejadwal')->name('dokter.updatejadwal')->middleware('dokter');

Route::get('/dokter/absensi', 'DokterController@indexabsensi')->name('dokter.absensi')->middleware('dokter');
Route::get('/dokter/dashboardabsensi', 'DokterController@dashboardabsensi')->name('dokter.dashboardabsensi')->middleware('dokter');
Route::get('/dokter/cetakabsensi/{param1}/{param2}', 'DokterController@cetakabsensi')->name('dokter.cetakabsensi')->middleware('dokter');
Route::get('/dokter/absenmasuk', 'DokterController@absenmasuk')->name('dokter.absenmasuk')->middleware('dokter');
Route::get('/dokter/absenkeluar', 'DokterController@absenkeluar')->name('dokter.absenkeluar')->middleware('dokter');

Route::get('/dokter/editprofile', 'DokterController@editprofile')->name('dokter.editprofile')->middleware('dokter');
Route::post('/dokter/updateprofile/{param}', 'DokterController@updateprofile')->name('dokter.updateprofile')->middleware('dokter');

Route::get('/dokter/indexresepobat', 'DokterController@indexresepobat')->name('dokter.indexresepobat')->middleware('dokter');
Route::get('/dokter/dashboardresepobat', 'DokterController@dashboardresepobat')->name('dokter.dashboardresepobat')->middleware('dokter');
Route::post('/dokter/storeresepobat', 'DokterController@storeresepobat')->name('dokter.storeresepobat')->middleware('dokter');
Route::get('/dokter/getresepobat/{param1}', 'DokterController@getresepobat')->name('dokter.getresepobat')->middleware('dokter');
Route::get('/dokter/updateresepobat', 'DokterController@updateresepobat')->name('dokter.updateresepobat')->middleware('dokter');
Route::get('/dokter/deleteresepobat/{param1}', 'DokterController@deleteresepobat')->name('dokter.deleteresepobat')->middleware('dokter');

Route::get('/dokter/indexpemeriksaan', 'DokterController@indexpemeriksaan')->name('dokter.indexpemeriksaan')->middleware('dokter');
Route::get('/dokter/dashboardpemeriksaan1', 'DokterController@dashboardpemeriksaan1')->name('dokter.dashboardpemeriksaan1')->middleware('dokter');
Route::get('/dokter/dashboardpemeriksaan2', 'DokterController@dashboardpemeriksaan2')->name('dokter.dashboardpemeriksaan2')->middleware('dokter');
Route::get('/dokter/createpemeriksaan/{param1}', 'DokterController@createpemeriksaan')->name('dokter.createpemeriksaan')->middleware('dokter');
Route::post('/dokter/storepemeriksaan', 'DokterController@storepemeriksaan')->name('dokter.storepemeriksaan')->middleware('dokter');
Route::get('/dokter/getharga/{param1}', 'DokterController@getharga')->name('dokter.getharga')->middleware('dokter');
Route::get('/dokter/createrujukan/{param1}', 'DokterController@createrujukan')->name('dokter.createrujukan')->middleware('dokter');
Route::post('/dokter/storerujukan', 'DokterController@storerujukan')->name('dokter.storerujukan')->middleware('dokter');

Route::get('/dokter/indexdatakontrol', 'DokterController@indexdatakontrol')->name('dokter.indexdatakontrol')->middleware('dokter');
Route::get('/dokter/dashboarddatakontrol', 'DokterController@dashboarddatakontrol')->name('dokter.dashboarddatakontrol')->middleware('dokter');
Route::get('/dokter/createdatakontrol/{param1}', 'DokterController@createdatakontrol')->name('dokter.createdatakontrol')->middleware('dokter');
Route::post('/dokter/storedatakontrol', 'DokterController@storedatakontrol')->name('dokter.storedatakontrol')->middleware('dokter');

//home
Route::get('/home', 'HomeController@index')->name('home');


//clear cache
Route::get('/cache-clear', function() {
    Artisan::call('cache:clear');
  
    dd("cache clear All");
});
