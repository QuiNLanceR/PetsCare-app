
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
      <a href="{{route('pasien.indexdatakontrol')}}" class="nav-link {{ strpos(request()->url(),'datakontrol') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
          Jadwal Kontrol
        </p>
      </a>
    </li>
    <li class="nav-header">Transaksi</li>
    <li class="nav-item">
      <a href="{{route('pasien.indexpemeriksaan')}}" class="nav-link {{ strpos(request()->url(),'pemeriksaan') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-paw"></i>
        <p>
          Pemeriksaan
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('pasien.indexpembayaran')}}" class="nav-link {{ strpos(request()->url(),'pembayaran') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>
          Pembayaran
        </p>
      </a>
    </li>
  </ul>
</nav>
<!-- /.sidebar-menu -->