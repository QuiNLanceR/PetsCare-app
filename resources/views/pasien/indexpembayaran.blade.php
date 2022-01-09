@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pembayaran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item">Transaksi</li>
              <li class="breadcrumb-item active">Pembayaran</li>
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
                <h3 class="card-title">Table Pembayaran</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblMaster" class="table table-bordered table-hover table-striped" style="width:100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>ID Pembayaran</th>
                    <th>Tanggal Pemeriksaan</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Nama Hewan</th>
                    <th>Jenis Hewan</th>
                    <th>Nama Dokter</th>
                    <th>Total Tagihan</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                </table>
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

    var url = '{{ route('pasien.dashboardpembayaran') }}';
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
      {data: 'id_pembayaran', name: 'id_pembayaran'},
      {data: 'tgl_pemeriksaan', name: 'tgl_pemeriksaan'},
      {data: 'tgl_pembayaran', name: 'tgl_pembayaran'},
      {data: 'nm_hewan', name: 'nm_hewan'},
      {data: 'jenis_hewan', name: 'jenis_hewan'},
      {data: 'nm_dokter', name: 'nm_dokter'},
      {data: 'total_tagihan', name: 'total_tagihan', orderable: false, className: 'text-center', searchable:false},
      {data: 'st_pembayaran', name: 'st_pembayaran', orderable: false, className: 'text-center', searchable:false},
      {data: 'action', name: 'action', orderable: false, className: 'text-center', searchable:false},
      ],
    });
  });
  
  function cetakstruk(id) {
    let url = "{{route('pasien.cetakstruk',['param1'])}}";
    url = url.replace('param1', id);

    window.open(url);
  }
</script>
@endsection
