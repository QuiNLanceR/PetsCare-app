<!DOCTYPE html>
<html>
  <head>
    @include ('layouts.headhome')  
  </head>
  <body>
    @yield('content')
    @include ('layouts.footerhome')   
    @include ('layouts.scripthome')
    @yield('scripts')
  </body>
</html>