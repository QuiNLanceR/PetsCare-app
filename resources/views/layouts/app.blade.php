<!DOCTYPE html>
<html>
  <head>
    @include ('layouts.head')  
  </head>
  <body class='hold-transition sidebar-mini layout-fixed'>
    @if(Auth::check())
      @php
        $sesuser = Auth::user()->getUser(Auth::user()->role,Auth::user()->username);
      @endphp
      @include('layouts.navbar')
      @include('layouts.sidebar')
      @yield('content')
      @include ('layouts.footer')   
      @include ('layouts.script')
      @yield('scripts')
    @endif()
  </body>
</html>
