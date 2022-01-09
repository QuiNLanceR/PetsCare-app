@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pemeriksaan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item">Transaksi</li>
              <li class="breadcrumb-item active">Pemeriksaan</li>
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
                <h3 class="card-title">Table Pasien Diperlukan Pemeriksaan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <table id="tblMaster" class="table table-bordered table-hover table-striped" style="width:100%">
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Hewan</th>
                        <th>Tanggal Daftar</th>
                        <th>Jenis Hewan</th>
                        <th>Keluhan</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Table Pasien Telah Dilakukan Pemeriksaan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <table id="tblDetail" class="table table-bordered table-hover table-striped" style="width:100%">
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Hewan</th>
                        <th>Tanggal Daftar</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Jenis Hewan</th>
                        <th>Keluhan</th>
                        <th>Diagnosis</th>
                        <th>Tindakan</th>
                        <th>Obat</th>
                        <th>Status</th>
                      </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
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

    var url = '{{ route('dokter.dashboardpemeriksaan1') }}';
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
      {data: 'nm_hewan', name: 'nm_hewan'},
      {data: 'tgl_pendaftaran', name: 'tgl_pendaftaran'},
      {data: 'jenis_hewan', name: 'jenis_hewan'},
      {data: 'keluhan', name: 'keluhan'},
      {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable:false},
      ],
    });  


    var url2 = '{{ route('dokter.dashboardpemeriksaan2') }}';
    var tableDetail = $('#tblDetail').DataTable({
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
      "order": [[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url2,
      columns: [
      {data: null, name: null},
      {data: 'nm_hewan', name: 'nm_hewan'},
      {data: 'tgl_pendaftaran', name: 'tgl_pendaftaran'},
      {data: 'tgl_pemeriksaan', name: 'tgl_pemeriksaan'},
      {data: 'jenis_hewan', name: 'jenis_hewan'},
      {data: 'keluhan', name: 'keluhan'},
      {data: 'diagnosis_pemeriksaan', name: 'diagnosis_pemeriksaan'},
      {data: 'tindakan_pemeriksaan', name: 'tindakan_pemeriksaan'},
      {data: 'obat', name: 'obat'},
      {data: 'status', name: 'status', className: 'text-center', orderable: false, searchable:false},
      ],
    });  
  });
</script>
@endsection
