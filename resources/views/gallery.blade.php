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
							<h1>See <em>Our</em> Gallery</h1>
                            <h2>Photo - photo kegiatan<em> PUSKESWAN</em></h2>
                            <span id="jelajah" style="color: white;font-size:30px;border: 3px solid red;border-radius: 5px;padding: 7px;font-family: 'Cormorant Garamond', Georgia, serif;">Jelajahi</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div id="fh5co-gallery" class="fh5co-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 fh5co-heading animate-box">
					<h2>Our Gallery</h2>
					<div class="row">
						<div class="col-md-6">
							<p>Dibawah ini merupakan photo-photo kegiatan UPTD PUSKESWAN Kab. Karawang dalam rangka menyehatkan hewan peliharaan anda.</p>
						</div>
					</div>
				</div>
				

				<div class="col-md-3 col-sm-3 fh5co-gallery_item">
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img1.jpg') }});" data-trigger="zoomerang"></div>
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img2.jpg') }});" data-trigger="zoomerang"></div>
				</div>
				<div class="col-md-6 col-sm-6 fh5co-gallery_item">
					<div class="fh5co-bg-img fh5co-gallery_big" style="background-image: url({{ asset('images/img3.jpg') }});" data-trigger="zoomerang"></div>
				</div>
				<div class="col-md-3 col-sm-3 fh5co-gallery_item">
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img4.jpg') }});" data-trigger="zoomerang"></div>
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img16.jpg') }});" data-trigger="zoomerang"></div>
				</div>

				<div class="col-md-3 col-sm-3 fh5co-gallery_item">
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img6.jpg') }});" data-trigger="zoomerang"></div>
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img7.jpg') }});" data-trigger="zoomerang"></div>
				</div>
				<div class="col-md-3 col-sm-3 fh5co-gallery_item">
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img8.jpg') }});" data-trigger="zoomerang"></div>
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img9.jpg') }});" data-trigger="zoomerang"></div>
				</div>
				<div class="col-md-6 col-sm-6 fh5co-gallery_item">
					<div class="fh5co-bg-img fh5co-gallery_big" style="background-image: url({{ asset('images/img10.jpg') }});" data-trigger="zoomerang"></div>
				</div>

				<div class="col-md-3 col-sm-3 fh5co-gallery_item">
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img11.jpg') }});" data-trigger="zoomerang"></div>
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img12.jpg') }});" data-trigger="zoomerang"></div>
				</div>
				<div class="col-md-6 col-sm-6 fh5co-gallery_item">
					<div class="fh5co-bg-img fh5co-gallery_big" style="background-image: url({{ asset('images/img5.jpg') }});" data-trigger="zoomerang"></div>
				</div>
				<div class="col-md-3 col-sm-3 fh5co-gallery_item">
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img14.jpg') }});" data-trigger="zoomerang"></div>
					<div class="fh5co-bg-img" style="background-image: url({{ asset('images/img15.jpg') }});" data-trigger="zoomerang"></div>
				</div>
				<div class="col-md-12 col-sm-12 fh5co-gallery_item">
					<div class="fh5co-bg-img fh5co-gallery_big" style="background-image: url({{ asset('images/img13.jpg') }});" data-trigger="zoomerang"></div>
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
                scrollTop: $("#fh5co-gallery").offset().top
            }, 2000);
        });
    }); 
</script>
@endsection