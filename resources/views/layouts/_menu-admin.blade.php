
<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item menu-open">
      <a href="{{route('home')}}" class="nav-link {{strpos(request()->url(),'home') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
    <li class="nav-header">Master</li>
    <li class="nav-item">
      <a href="{{route('admin.indexdatadokter')}}" class="nav-link {{ strpos(request()->url(),'datadokter') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
          Data Dokter
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('admin.indexdatapasien')}}" class="nav-link {{ strpos(request()->url(),'datapasien') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
          Data Pemilik Hewan
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('admin.indexabsensi')}}" class="nav-link {{ strpos(request()->url(),'absensi') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard"></i>
        <p>
          Absensi
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('admin.indexjadwaldokter')}}" class="nav-link {{ strpos(request()->url(),'jadwaldokter') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>
          Jadwal Dokter
        </p>
      </a>
    </li>
    <li class="nav-header">Transaksi</li>
    <li class="nav-item">
      <a href="{{route('admin.indexpembayaran')}}" class="nav-link {{ strpos(request()->url(),'pembayaran') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-cash-register"></i>
        <p>
          Pembayaran
        </p>
      </a>
    </li>
  </ul>
</nav>
<!-- /.sidebar-menu -->