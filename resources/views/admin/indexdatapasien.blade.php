@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Pemilik Hewan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item">Master</li>
              <li class="breadcrumb-item active">Data Pemilik Hewan</li>
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
                <h3 class="card-title">Table Data Pemilik Hewan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="{{route('admin.createdatapasien')}}"><span class="btn btn-md btn-primary" style="margin-bottom:15px;"><i class="fas fa-plus"></i> Data Pemilik Hewan</span></a>
                <table id="tblMaster" class="table table-bordered table-hover table-striped" style="width:100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tempat Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>No Handphone</th>
                    <th>Photo</th>
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

    var url = '{{ route('admin.dashboarddatapasien') }}';
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
      {data: 'nik_pasien', name: 'nik_pasien'},
      {data: 'nm_pasien', name: 'nm_pasien'},
      {data: 'email_pasien', name: 'email_pasien'},
      {data: 'ttl', name: 'ttl'},
      {data: 'jen_kel_pasien', name: 'jen_kel_pasien', orderable: false, searchable:false},
      {data: 'alamat_pasien', name: 'alamat_pasien', orderable: false, searchable:false},
      {data: 'no_hp_pasien', name: 'no_hp_pasien'},
      {data: 'photo_pasien', name: 'photo_pasien', orderable: false, searchable:false},
      {data: 'action', name: 'action', orderable: false, searchable:false},
      ],
    });  
  });

  function hapusdata(nik)
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
        var url = "{{route('admin.deletedatapasien',['param1'])}}";
        url = url.replace('param1',nik);

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
</script>
@endsection
