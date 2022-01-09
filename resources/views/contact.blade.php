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
							<h1>Kontak Kami</h1>
                            <h2>Pusat Kesehatan Hewan Kab.<em> Karawang</em></h2>
                            <span id="jelajah" style="color: white;font-size:30px;border: 3px solid red;border-radius: 5px;padding: 7px;font-family: 'Cormorant Garamond', Georgia, serif;">Jelajahi</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div id="fh5co-contact" class="fh5co-section animate-box">
		<div class="container">
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
					<h2>Don't be shy, let's chat.</h2>
					<p>Hubungi kami segera jika hewan peliharaan anda membutuhkan perawatan dan penanganan medis</p>
					<p><a href="mailto:imbarscout@gmail.com" class="btn btn-primary btn-outline">Contact Us</a></p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<form action="#" id="form-wrap">
						<div class="row form-group">
							<div class="col-md-12">
                                <div class="mapouter"><div class="gmap_canvas"><iframe width="500" height="655" id="gmap_canvas" src="https://maps.google.com/maps?q=puskeswan%20karawang&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://fmovies-online.net"></a><br><style>.mapouter{position:relative;text-align:right;height:655px;width:490px;}</style><a href="https://www.embedgooglemap.net">google maps plugin html</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:655px;width:490px;}</style></div></div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-6 col-sm-6">
					<form action="#" method="" id="form-wrap">
						@csrf
						<div class="row form-group">
							<div class="col-md-12">
								<label for="name">Your Name</label>
								<input type="text" class="form-control" id="name" name="name">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<label for="email">Your Email</label>
								<input type="email" class="form-control" id="email" name="email">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<label for="message">Your Message</label>
								<textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<input type="submit" id="btn-submit" class="btn btn-primary btn-outline btn-lg" value="Submit Form">
							</div>
						</div>
					</form>
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

		$("#btn-submit").on('click', function(e){
			e.preventDefault();
			let name = $("#name").val();
			let email = $("#email").val();
			let message = $("#message").val();
			url = "{{ route('/sendmailcontact',['name','email','message']) }}";
			url	= url.replace('name',window.btoa(name));
			url	= url.replace('email',window.btoa(email));
			url	= url.replace('message',window.btoa(message));

			$.get(url, function(_response){
				console.log(_response);
			})
		});
    }); 
</script>
@endsection