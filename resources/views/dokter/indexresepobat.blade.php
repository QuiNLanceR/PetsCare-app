@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Resep Obat</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item">Master</li>
              <li class="breadcrumb-item active">Resep Obat</li>
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
                <h3 class="card-title">Table Resep Obat</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <span class="btn btn-md btn-primary" data-toggle="modal" data-target="#modal-form" style="margin-bottom:15px;" id="btn-add"><i class="fas fa-plus"></i> Resep Obat</span>
                <table id="tblMaster" class="table table-bordered table-hover table-striped" style="width:100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Harga Obat</th>
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
                <label for="nm_obat">Nama Obat</label>
                <input type="text" name="nm_obat" class="form-control" placeholder="Nama Obat" id="nm_obat">
                <input type="hidden" readonly name="id_obat" class="form-control" id="id_obat">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="harga_obat">Harga</label>
                <input type="number" placeholder="Harga Obat" name="harga_obat" id="harga_obat" class="form-control">
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

@section('scripts')
<script>
  $(document).ready(function(){

    var url = '{{ route('dokter.dashboardresepobat') }}';
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
      {data: 'nm_obat', name: 'nm_obat'},
      {data: 'harga_obat', name: 'harga_obat'},
      {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable:false},
      ],
    });

    $("#btn-add").on('click',function(e){
      e.preventDefault();
      $('#titlemodal').html('Add Data');
      $('#harga_obat').val('');
      $('#id_obat').val('');
      $('#nm_obat').val('');
    });

    $("#btn-simpan").on('click',function(e){
      e.preventDefault();
      let idobat = $("#id_obat").val();
      if (idobat == '') {
        simpandata();
      } else {
        ubahdata();
      }
    }) 
  });

  function simpandata()
  {
    if ($("#hari").val() != '') {
      let url = "{{route('dokter.storeresepobat')}}";

      $.ajax({
        url      : url,
        type     : 'post',
        data     : $("#form_id").serialize(),
        dataType : 'json',
        success: function(_response){
          if (_response.indctr == 1) {
            Swal.fire('Berhasil!', _response.msg,'success');
            $('#modal-form').modal('hide');
            $('#tblMaster').DataTable().ajax.reload();
            $('#harga_obat').val('');
            $('#id_obat').val('');
            $('#nm_obat').val('');
          } else {
            Swal.fire('Perhatian!','Data Gagal diubah ' + _response.msg,'error');
          }
        },
        error: function(_response){
            $('#id_dokter').val('').trigger('change');
            $('#hari').val('').trigger('change');
            $('#harga_obat').val('');
            $('#id_obat').val('');
            $('#nm_obat').val('');
          Swal.fire(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'info'
          )
        }
      });
    } else {
      Swal.fire('Perhatian!','Harap jangan kosongkan jadwal dokter!','warning');
    }
  }

  function editdata(id)
  {
    $('#modal-form').modal('show');
    $('#titlemodal').html('Edit Data');

    let url = "{{route('dokter.getresepobat',['param1'])}}";
    url = url.replace('param1', id);

    $.get(url, function(_response){
      if (_response.indctr == 1) {
        $("#id_obat").val(_response.data['id_obat']);
        $("#nm_obat").val(_response.data['nm_obat']);
        $("#harga_obat").val(_response.data['harga_obat']);
      } else {
        $('#modal-form').modal('hide');
        $('#harga_obat').val('');
        $('#id_obat').val('');
        $('#nm_obat').val('');
        Swal.fire('Perhatian!','Terjadi Kesalahan saat generate data!','warning')
      }
    })
  }

  function ubahdata()
  {
    if ($("#hari").val() != '') {
      let url = "{{route('dokter.updateresepobat')}}";

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
      Swal.fire('Perhatian!','Harap jangan kosongkan jadwal dokter!','warning');
    } 
  }

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
        var url = "{{route('dokter.deleteresepobat',['param1'])}}";
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
