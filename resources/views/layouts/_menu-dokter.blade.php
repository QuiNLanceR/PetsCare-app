
<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="{{route('home')}}" class="nav-link {{strpos(request()->url(),'home') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
    <li class="nav-header">Master</li>
    <li class="nav-item">
      <a href="{{route('dokter.indexjadwaldokter')}}" class="nav-link {{ strpos(request()->url(),'jadwal') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>
          Jadwal Dokter
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('dokter.absensi')}}" class="nav-link {{ strpos(request()->url(),'absensi') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard"></i>
        <p>
          Absensi
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('dokter.indexresepobat')}}" class="nav-link {{ strpos(request()->url(),'resepobat') !== false ? 'active' : '' }}">
        <i class="nav-icon fas fa-book-medical"></i>
        <p>
          Resep Obat
        </p>
      </a>
    </li>
    <li class="nav-header">Transaksi</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Pelayanan
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('dokter.indexpemeriksaan')}}" class="nav-link {{ strpos(request()->url(),'pemeriksaan') !== false ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Pemeriksaan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('dokter.indexdatakontrol')}}" class="nav-link {{ strpos(request()->url(),'datakontrol') !== false ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data Kontrol</p>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>
<!-- /.sidebar-menu -->