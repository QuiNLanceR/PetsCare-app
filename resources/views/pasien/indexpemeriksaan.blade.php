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
                <h3 class="card-title">Table Pendaftaran <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-notif"> <i class="fas fa-info"></i>
                 </button></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row" style="margin-bottom:20px;">
                    @if($datadaftar->jml == 0)
                      <div class="col-md-2">
                        <span class="btn btn-md btn-primary" id="btn-antri"> Ambil Antrian</span>
                      </div>
                    @else
                      <div class="col-md-12">
                        <span class="text-center"> Anda telah mengambil nomor antrian hari ini, mohon selesaikan pemeriksaan terlebih dahulu sebelum melakukan pendaftaran kembali.</span>
                      </div>
                    @endif
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <table id="tblMaster" class="table table-bordered table-hover table-striped" style="width:100%">
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Hewan</th>
                        <th>Tanggal Daftar</th>
                        <th>Jenis Hewan</th>
                        <th>No Antrian</th>
                        <th>Keluhan</th>
                        <th>Status</th>
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
                <h3 class="card-title">Table Pemeriksaan</h3>
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

  <div class="modal fade" id="modal-notif">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Info:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            Klik tombol ambil antrian <b>(jika anda belum mengambil nomor antrian hari ini)</b> untuk melakukan pendaftaran.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


  <div class="modal fade" id="modal-form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="titlemodal"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" method="post" id="form_id" class="form-horizontal">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <label for="nm_hewan">Nama Hewan</label>
                <input type="text" name="nm_hewan" class="form-control" id="nm_hewan">
                <input type="hidden" readonly name="id_pendaftaran" class="form-control" id="id_pendaftaran">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('jenis_hewan', 'Jenis Hewan') !!}
                <select name="jenis_hewan" id="jenis_hewan" class="form-control">
                  <option value="">~ Pilih ~</option>
                  <option value="Kucing">Kucing</option>
                  <option value="Anjing">Anjing</option>
                  <option value="Kelinci">Kelinci</option>
                  <option value="Musang">Musang</option>
                  <option value="Landak Mini">Landak Mini</option>
                  <option value="Reptil">Reptil</option>
                  <option value="Hamster">Hamster</option>
                </select>
                {!! $errors->first('jenis_hewan', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-md-6">
                <label for="keluhan">Keluhan</label>
                <textarea name="keluhan" id="keluhan" class="form-control" cols="10" rows="2"></textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary" id="btn-simpan">Save</button>
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
    $('#modal-notif').modal('show');

    var url = '{{ route('pasien.dashboardpendaftaran') }}';
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
      "order": [[2, 'desc']],
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
      {data: 'no_antrian', name: 'no_antrian', className: 'text-center'},
      {data: 'keluhan', name: 'keluhan'},
      {data: 'st_pendaftarans', name: 'st_pendaftarans', className: 'text-center', orderable: false, searchable:false},
      {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable:false},
      ],
    });  

    var url2 = '{{ route('pasien.dashboardpemeriksaan') }}';
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

    $('#btn-antri').on('click', function(e){
      e.preventDefault();
      url = "{{route('pasien.createpemeriksaan')}}";
      window.location.href = url;
    });

    $('#btn-simpan').on('click',function(e){
      e.preventDefault();
      simpandata();
    });
  });

  function hapusdata(id)
  {
   Swal.fire({
      title: 'Yakin menghapus data ini?',
      text: '',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: 'red',
      cancelButtonColor: 'grey',
      confirmButtonText: '<i class="fa fa-check-circle" ></i> Ya',
      cancelButtonText: '<i  class="fa fa-times" ></i> Tidak',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function(result){
      
      if (result.isConfirmed) {
        var url = "{{route('pasien.deletepemeriksaan',['param1'])}}";
        url = url.replace('param1',id);

        $.ajax({
          url      : url,
          type     : 'GET',
          dataType : 'json',
          success: function(_response){
           if(_response.indctr == '1'){      
            Swal.fire('Sukses', _response.msg,'success'
              )
            $('.modal').modal('hide');
            $('#tblMaster').DataTable().ajax.reload();
            location.reload();
          } else if(_response.indctr == '0'){
            Swal.fire('Terjadi kesalahan saat menghapus', _response.msg, 'info'
              )
          }
        },
        error: function(){
          Swal.fire(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'info'
            )
          }
        });      
      } else if (result.isDismissed) {
        $('.modal').modal('hide');
      }
    }) 
  }


  function editdata(id)
  {
    $('#modal-form').modal('show');
    $('#titlemodal').html('Edit Data');

    let url = "{{route('pasien.getpemeriksaan',['param1'])}}";
    url = url.replace('param1', id);

    $.get(url, function(_response){
      if (_response.indctr == 1) {
        $("#id_pendaftaran").val(_response.data['id_pendaftaran']);
        $("#nm_hewan").val(_response.data['nm_hewan']);
        $("#keluhan").val(_response.data['keluhan']);
        $("#jenis_hewan").val(_response.data['jenis_hewan']).trigger('change');
      } else {
        $('#modal-form').modal('hide');
        $("#id_pendaftaran").val('');
        $("#nm_hewan").val('');
        $("#keluhan").val('');
        $("#jenis_hewan").val('').trigger('change');
        Swal.fire('Perhatian!','Terjadi Kesalahan saat generate data!','warning')
      }
    })
  }

  function simpandata()
  {
    if ($("#kehadiran").val() != '') {
      let url = "{{route('pasien.updatepemeriksaan')}}";

      $.ajax({
        url      : url,
        type     : 'get',
        data     : $("#form_id").serialize(),
        dataType : 'json',
        success: function(_response){
          if (_response.indctr == 1) {
            Swal.fire('Berhasil!', _response.msg,'success');
            $('#modal-form').modal('hide');
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

  function cetakrujukan(id) {
    let url = "{{route('pasien.cetakrujukan',['param1'])}}";
    url = url.replace('param1', id);

    window.open(url);
  }

</script>
@endsection
