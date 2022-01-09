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
                <table id="tblMaster" class="table table-bordered table-hover table-striped" style="width:100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Kehadiran</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                </table>
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


  <div class="modal fade" id="modal-editabsensi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" method="post" id="form_id" class="form-horizontal">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <label for="nm_dokter">Nama Dokter</label>
                <input type="text" name="nm_dokter" placeholder="Nama Dokter" readonly class="form-control" id="nm_dokter">
                <input type="hidden" name="id_absen" class="form-control" id="id_absen">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="tgl_absen">Tanggal Absen</label>
                <input type="date" id="tgl_absen" name="tgl_absen" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="jam_masuk">Jam Masuk</label>
                <input type="time" name="jam_masuk" class="form-control" id="jam_masuk">
              </div>
              <div class="col-md-6">
                <label for="jam_keluar">Jam Keluar</label>
                <input type="time" name="jam_keluar" class="form-control" id="jam_keluar">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="kehadiran">Kehadiran</label>
                <select name="kehadiran" required id="kehadiran" class="form-control">
                  <option value="">~ Pilih ~</option>
                  <option value="y">Hadir</option>
                  <option value="t">Tidak</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary" id="btn-simpan">Ubah</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
@endsection
@section('scripts')
<script>
  $(document).ready(function(){

    var url = '{{ route('admin.dashboardabsensi') }}';
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
      {data: 'action', name: 'action', orderable: false, searchable:false, className: 'text-center'},
      ],
    });  

    $('#btn-cetak').on('click',function(e){
      e.preventDefault();
      let tgl_awal = $('#tgl_awal').val();
      let tgl_akhir = $('#tgl_akhir').val();
      cetak(tgl_awal, tgl_akhir)
    });

    $('#btn-simpan').on('click',function(e){
      e.preventDefault();
      simpandata();
    });
  });

  function cetak(tgl_awal, tgl_akhir) {
    if (tgl_awal != '') {
      if (tgl_akhir != '') {
        let url = "{{route('admin.cetakabsensi',['param1','param2'])}}";
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

  function editabsen(id)
  {
    $('#modal-editabsensi').modal('show');

    let url = "{{route('admin.getdataabsensi',['param1'])}}";
    url = url.replace('param1', id);

    $.get(url, function(_response){
      if (_response.indctr == 1) {
        $("#id_absen").val(_response.data['id_absen']);
        $("#nm_dokter").val(_response.data['nm_dokter']);
        $("#jam_masuk").val(_response.data['jam_masuk']);
        $("#jam_keluar").val(_response.data['jam_keluar']);
        $("#tgl_absen").val(_response.data['tgl_absen']);
        $("#kehadiran").val(_response.data['kehadiran']).trigger('change');
      } else {
        $('#modal-editabsensi').modal('hide');
        Swal.fire('Perhatian!','Terjadi Kesalahan saat generate data!','warning')
      }
    })
  }

  function simpandata()
  {
    if ($("#kehadiran").val() != '') {
      let url = "{{route('admin.updateabsen')}}";

      $.ajax({
        url      : url,
        type     : 'get',
        data     : $("#form_id").serialize(),
        dataType : 'json',
        success: function(_response){
          if (_response.indctr == 1) {
            Swal.fire('Berhasil!', _response.msg,'success');
            $('#modal-editabsensi').modal('hide');
            $('#tblMaster').DataTable().ajax.reload();
          } else {
            Swal.fire('Perhatian!','Data Gagal diubah karena:' + _response.msg,'error');
          }
        },
        error: function(_response){
          Swal.fire(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'info'
          )
        }
      });
    } else {
      Swal.fire('Perhatian!','Harap pilih kehadiran terlebih dahulu!','warning');
    }
  }
</script>
@endsection
