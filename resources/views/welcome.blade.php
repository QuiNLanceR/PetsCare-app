@extends('layouts.apphome')

@section('content')        
    <div class="fh5co-loader"></div>
    
    <div id="page">
    <nav class="fh5co-nav" role="navigation">
        @include('layouts.headerhome')
    </nav>

    <header id="fh5co-header" class="fh5co-cover js-fullheight" role="banner" style="background-image: url({{asset('images/puskeswan.png')}});" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="display-t js-fullheight">
                        <div class="display-tc js-fullheight animate-box" data-animate-effect="fadeIn">
                            <h1>Selamat Datang</h1>
                            <h2><em>Aplikasi Klinik Hewan Kabupaten Karawang</em></h2>
                            <span id="jelajah" style="color: white;font-size:30px;border: 3px solid red;border-radius: 5px;padding: 7px;font-family: 'Cormorant Garamond', Georgia, serif;">Jelajahi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-about" class="fh5co-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-pull-4 img-wrap animate-box" data-animate-effect="fadeInLeft">
                    <img src="{{asset('images/puskeswan.png')}}" alt="PetsCare Images">
                </div>
                <div class="col-md-5 col-md-push-1 animate-box">
                    <div class="section-heading">
                        <h2>Tugas & Fungsi</h2>
                        <p>UPTD KLINIK HEWAN KARAWANG (PUSKESWAN) Sebagai unit pelayanan kesehatan hewan terpadu memegang peranan yang sangat penting dalam meningkatkan mutu pelayanan kepada masyarakat yaitu pelayanan diagnosa penyakit, pengobatan dan penanganan masalah reproduksi di wilayah Kota Karawang</p>
                        <p>
                            Sesuai dengan Peraturan Menteri Pertanian Nomor 64/Permentan/Ot.140/9/2007 Tentang Pedoman Pelayanan Pusat Kesehatan Hewan. <br>
                            UPTD. Puskeswan Pemerintah Kota Karawang mempunyai Tugas Pokok dan Fungsi sebagai berikut:
                            <ul>
                                <li>TUGAS</li>
                                <ul>
                                    <li>Melakukan kegiatan pelayanan kesehatan hewan</li>
                                    <li>Melaksanakan konsultasi kesehatan hewan peliharaan masyarakat dan penyuluhan dibidang kesehatan hewan</li>
                                    <li>Memberikan surat keterangan dokter hewan</li>
                                </ul>
                                <li>FUNGSI</li>
                                <ul>
                                    <li>Menyelenggarakan penyehatan hewan</li>
                                </ul>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="fh5co-featured-menu" class="fh5co-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 fh5co-heading animate-box">
                    <h2>Dokter</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <p>UPTD Pusat Kesehatan Hewan Kab. KARAWANG memiliki beberapa dokter yang berkompeten dibidangnya, sehingga anda dapat memeriksa kesehatan hewan peliharaan anda dengan aman dan tenang.</p>
                        </div>
                    </div>
                </div>
                @foreach($dokter as $val)
                    @if($loop->iteration % 2 == 0)
                        <div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-item-wrap animate-box">
                            <div class="fh5co-item margin_top">
                                <img src="{{ asset('images/photo/$val->photo_dokter') }}" class="img-responsive" alt="PetsCare Images">
                                <h3>{{ $val->nm_dokter }}</h3>
                                <span class="fh5co-price">$19<sup>.00</sup></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos nihil cupiditate ut vero alias quaerat inventore molestias vel suscipit explicabo.</p>
                            </div>
                        </div>
                        <div class="clearfix visible-sm-block visible-xs-block"></div>
                    @else
                        <div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-item-wrap animate-box">
                            <div class="fh5co-item margin_top">
                                @if($val->photo_dokter != null)
                                    <img src="{{ asset('images/photo/'.$val->photo_dokter) }}" class="img-responsive" alt="PetsCare Images">
                                @else
                                    <img src="{{ asset('images/no_image.png') }}" class="img-responsive" alt="PetsCare Images">
                                @endif
                                <h3>{{ $val->nm_dokter }}</h3>
                                <span class="fh5co-price">{{ $val->email_dokter }}</span>
                                <p>Dokter ini merupakan {{ $val->jen_kel_dokter == 'p' ? 'perempuan' : 'laki-laki' }} kelahiran tahun {{ substr($val->tgl_lah_dokter,0,4) }} di daerah {{ $val->tmp_lah_dokter }}. <br> No Handphone: {{ $val->no_hp_dokter }}. <br> Jadwal Dokter: {{ $val->senin == 't' ? 'Senin,' : '' }} {{ $val->selasa == 't' ? 'Selasa,' : '' }} {{ $val->rabu == 't' ? 'Rabu,' : '' }} {{ $val->kamis == 't' ? 'Kamis,' : '' }} {{ $val->jumat == 't' ? "jum'at," : '' }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div id="fh5co-blog" class="fh5co-section">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading animate-box">
                    <h2>Alamat UPTD Puskeswan</h2>
                    <p>Jl. Gandaria, Nagasari, Kec. Karawang Barat., Kab. Karawang, Jawa Barat 41314.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
    var scrolled=0;
    $( document ).ready(function() {
        $("#jelajah").click(function() {
            $('html, body').animate({
                scrollTop: $("#fh5co-about").offset().top
            }, 2000);
        });
    }); 
</script>
@endsection