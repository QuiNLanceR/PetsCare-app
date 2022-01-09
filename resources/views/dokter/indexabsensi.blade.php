@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Absensi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item">Master</li>
              <li class="breadcrumb-item active">Absensi</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Table Absensi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row" style="margin-bottom:20px;">
                  <div class="col-md-2">
                    <div class="box" style="border: 2px solid black;padding:10px;vertical-align: middle;">
                      @php
                        $daynow = \Carbon\Carbon::now()->format('D');
                        $timenow = \Carbon\Carbon::now()->format('H:i');
                      @endphp
                      <center>
                        @if($daynow == 'Sun' || $daynow == 'Sat' || $daynow == 'Sab' || $daynow == 'Min')
                          <span class="btn btn-md btn-danger"> Belum Mulai</span>
                        @else
                          @if($timenow >= '07:30' && $timenow <= '15:00')
                            @if($getabsensi1->jml == 0 && $getabsensi2->jml == 0)
                              <span class="btn btn-md btn-success" id="btn-masuk"> Absen Masuk</span>
                            @elseif($getabsensi1->jml == 0 && $getabsensi2->jml > 0)
                              <span class="btn btn-md btn-info"> Sudah Absen</span>
                            @endif
                          @elseif($timenow >= '15:01' && $timenow <= '17:00')
                            @if($getabsensi2->jml > 0)
                              <span class="btn btn-md btn-success" id="btn-keluar"> Absen Keluar</span>
                            @else
                              <span class="btn btn-md btn-danger"> Belum Mulai</span>
                            @endif                            
                          @else
                            <span class="btn btn-md btn-danger"> Belum Mulai</span>
                          @endif
                        @endif
                      </center>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <table id="tblMaster" class="table table-bordered table-hover table-striped" style="width:100%">
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Kehadiran</th>
                      </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-3">
                    <label for="tgl_awal">Tanggal Awal</label>
                    <input type="date" id="tgl_awal" class="form-control">
                  </div>
                  <div class="col-md-3">
                    <label for="tgl_akhir">Tanggal Akhir</label>
                    <input type="date" id="tgl_akhir" class="form-control">
                  </div>
                  <div class="col-md-3">
                    <label for="action">Action</label>
                    <div class="input-group">
                      <span class="btn btn-primary" id="btn-cetak"><i class="fas fa-print"></i> Cetak Absensi</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
@section('scripts')
<script>
  $(document).ready(function(){

    var url = '{{ route('dokter.dashboardabsensi') }}';
    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      {data: null, name: null},
      {data: 'nm_dokter', name: 'nm_dokter'},
      {data: 'tgl_absen', name: 'tgl_absen'},
      {data: 'jam_masuk', name: 'jam_masuk'},
      {data: 'jam_keluar', name: 'jam_keluar'},
      {data: 'kehadiran', name: 'kehadiran', className: 'text-center', orderable: false, searchable:false},
      ],
    });  

    $('#btn-cetak').on('click',function(e){
      e.preventDefault();
      let tgl_awal = $('#tgl_awal').val();
      let tgl_akhir = $('#tgl_akhir').val();
      cetak(tgl_awal, tgl_akhir)
    });

    $('#btn-masuk').on('click', function(e){
      e.preventDefault();
      url = "{{route('dokter.absenmasuk')}}";
      $.get(url,function(_response){
        if (_response.indctr == 1) {
          Swal.fire('Berhasil!','Selamat anda telah berhasil absen','success');
          location.reload();
        } else {
          Swal.fire('Perhatian!','Absen gagal mohon refresh halaman ini!','warning');
        }
      });
    });

    $('#btn-keluar').on('click', function(e){
      e.preventDefault();
      url = "{{route('dokter.absenkeluar')}}";
      $.get(url,function(_response){
        if (_response.indctr == 1) {
          Swal.fire('Berhasil!','Anda telah absen keluar!','success');
          location.reload();
        } else {
          Swal.fire('Perhatian!','Absen gagal mohon refresh halaman ini!','warning');
        }
      });
    });
  });

  function cetak(tgl_awal, tgl_akhir) {
    if (tgl_awal != '') {
      if (tgl_akhir != '') {
        let url = "{{route('dokter.cetakabsensi',['param1','param2'])}}";
        url = url.replace('param1', window.btoa(tgl_awal));
        url = url.replace('param2', window.btoa(tgl_akhir));

        window.open(url);
      } else {
        Swal.fire('Perhatian!','Tanggal Akhir tidak boleh kosong!','warning').then(function(){
          $('#tgl_akhir').focus();
        });
      }
    } else {
      Swal.fire('Perhatian!','Tanggal Awal tidak boleh kosong!','warning').then(function(){
        $('#tgl_awal').focus();
      });
    }
  }
</script>
@endsection
