<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('home')}}" class="brand-link">
    <img src="{{ asset('images/favicon.png') }}" alt="PetsCare-app Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">PetsCare App</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(Auth::user()->role == 'admin')
          @if($sesuser->photo_admin == null)
            <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="img-circle elevation-2" alt="User Image">
          @else
            <img src="{{ asset('images/photo/'.$sesuser->photo_admin) }}" class="img-circle elevation-2" alt="User Image">          
          @endif
        @elseif(Auth::user()->role == 'pasien')
          @if($sesuser->photo_pasien == null)
            <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="img-circle elevation-2" alt="User Image">
          @else
            <img src="{{ asset('images/photo/'.$sesuser->photo_pasien) }}" class="img-circle elevation-2" alt="User Image">          
          @endif
        @elseif(Auth::user()->role == 'dokter')
          @if($sesuser->photo_dokter == null)
            <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="img-circle elevation-2" alt="User Image">
          @else
            <img src="{{ asset('images/photo/'.$sesuser->photo_dokter) }}" class="img-circle elevation-2" alt="User Image">          
          @endif
        @endif
      </div>
      <div class="info">
        <a href="#" class="d-block">{{Auth::user()->name}}</a>
      </div>
    </div>

    @if(Auth::user()->role == 'admin')
      @include('layouts._menu-admin')
    @elseif(Auth::user()->role == 'pasien')
      @include('layouts._menu-pasien')
    @elseif(Auth::user()->role == 'dokter')
      @include('layouts._menu-dokter')
    @else
    <span style="color: red; font-size: 15px;font-weight: bold;">You Login Using Ilegal Account</span>
    @endif
  </div>
  <!-- /.sidebar -->
</aside>