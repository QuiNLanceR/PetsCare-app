@extends('layouts.apphome')

@section('content')        
    <div class="fh5co-loader"></div>
    
    <div id="page">
    <nav class="fh5co-nav" role="navigation">
        @include('layouts.headerhome')
    </nav>
    
	<header id="fh5co-header" class="fh5co-cover js-fullheight" role="banner" style="background-image:url({{asset('images/puskeswan.png')}});" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="display-t js-fullheight">
						<div class="display-tc js-fullheight animate-box" data-animate-effect="fadeIn">
							<h1>Tentang PUSKESWAN</h1>
                            <h2>Pusat Kesehatan Hewan Kab.<em> Karawang</em></h2>
                            <span id="jelajah" style="color: white;font-size:30px;border: 3px solid red;border-radius: 5px;padding: 7px;font-family: 'Cormorant Garamond', Georgia, serif;">Jelajahi</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div id="fh5co-timeline">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0">
					<ul class="timeline animate-box">
						<li class="timeline-heading text-center animate-box">
							<div><h3>Perkembangan Puskeswan</h3></div>
						</li>
						<li class="animate-box timeline-unverted">
							<div class="timeline-badge"><i class="icon-genius"></i></div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<h3 class="timeline-title">Awal mula terbentuk</h3>
								
								</div>
								<div class="timeline-body">
									<p>Dibentuknya UPTD Puskeswan adalah sebagai unsur pelaksanaan tugas teknis operasional Dinas Perikanan Pertanian dan Pangan di bidang pelayanan kesehatan hewan, kesehatan reproduksi ternak serta pelayanan teknologi peternakan seperti biogas dan inseminasi buatan.</p>
								</div>
							</div>
						</li>
						<li class="timeline-inverted animate-box">
							<div class="timeline-badge"><i class="icon-genius"></i></div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<h3 class="timeline-title">Proses Perkembangan</h3>
								</div>
								<div class="timeline-body">
									<p>Saat ini kami puskeswan sudah memiliki beberapa dokter spesialis hewan beserta asisten dokternya.</p>
								</div>
							</div>
						</li>
						<li class="animate-box timeline-unverted">
							<div class="timeline-badge"><i class="icon-genius"></i></div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<h3 class="timeline-title">Dibukanya ruang sterilisasi</h3>
								</div>
								<div class="timeline-body">
									<p>Kami sudah memiliki ruangan khusus untuk mensterilisasi hewan peliharaan anda.</p>
								</div>
							</div>
						</li>
			    	</ul>
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
                scrollTop: $("#fh5co-timeline").offset().top
            }, 2000);
        });
    }); 
</script>
@endsection