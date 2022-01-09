<!-- <div class="top-menu"> -->
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center logo-wrap">
                <div id="fh5co-logo"><a href="#">PetsCare<span>.</span></a></div>
            </div>
            <div class="col-xs-12 text-center menu-1 menu-wrap">
                <ul>
                    <li id="home" class="{{ request()->url() == route('/') ? 'active' : '' }}"><a href="#">Home</a></li>
                    <li id="tentang" class="{{ request()->url() == route('/about') ? 'active' : '' }}"><a href="{{ route('/about') }}">Tentang</a></li>
                    <li id="galeri" class="{{ request()->url() == route('/gallery') ? 'active' : '' }}"><a href="{{ route('/gallery') }}">Galeri</a></li>
                    <li id="kontak" class="{{ request()->url() == route('/contact') ? 'active' : '' }}"><a href="{{ route('/contact') }}">Kontak</a></li>
                    <li class="has-dropdown">
                        <a href="#"><i class="icon-user2"></i> Akun</a>
                        <ul class="dropdown">
                            <li id="login"><a href="{{route('home')}}"> {{ Auth::check() ? ucwords(Auth::user()->name) : 'Login'}}</a></li>
                            @if(Auth::check())
                            @else
                                <li id="register"><a href="{{route('register')}}">Registers</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        
    </div>
<!-- </div> -->
