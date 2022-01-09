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
              <li class="breadcrumb-item"><a href="{{route('pasien.indexpembayaran')}}">Pembayaran</a></li>
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
                <h3 class="card-title">Form Pembayaran</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <!-- form start -->
                    {!! Form::open(['url' => route('admin.storepembayaran'),
                        'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
                       @csrf
                       <div class="form-group row">
                        <div class="col-md-4">
                          {!! Form::label('id_pembayaran', 'No Pembayaran') !!}
                          {!! Form::text('id_pembayaran', $datapembayaran->id_pembayaran, ['class'=>'form-control','placeholder' => 'No Pembayaran', 'required', 'readonly']) !!} 
                          {!! Form::hidden('id_pemeriksaan', $datapembayaran->id_pemeriksaan, ['class'=>'form-control','placeholder' => 'No Pemeriksaan', 'required', 'readonly']) !!} 
                          {!! Form::hidden('id_pendaftaran', $datapembayaran->id_pendaftaran, ['class'=>'form-control','placeholder' => 'No Pemeriksaan', 'required', 'readonly']) !!} 
                          {!! $errors->first('id_pembayaran', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('total_tagihan', 'Total Tagihan') !!}
                          {!! Form::number('total_tagihan', $ttlhrg, ['class'=>'form-control','placeholder' => 'Total Tagihan', 'required', 'readonly']) !!} 
                          {!! $errors->first('total_tagihan', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('uang_bayar', 'Uang Bayar') !!}
                          {!! Form::number('uang_bayar', null, ['class'=>'form-control','placeholder' => 'Uang Bayar', 'required', 'min' => '0', 'onchange' => 'ukem()']) !!} 
                          {!! $errors->first('uang_bayar', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-4">
                          {!! Form::label('uang_kembali', 'Uang Kembali') !!}
                          {!! Form::number('uang_kembali', 0, ['class'=>'form-control','placeholder' => 'Uang Kembali', 'required', 'readonly']) !!} 
                          {!! $errors->first('uang_kembali', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('ket_pembayaran', 'Keterangan Pembayaran') !!}
                          {!! Form::textarea('ket_pembayaran', null, ['class'=>'form-control','placeholder' => 'Keterangan Pembayaran', 'required', 'cols' => '10', 'rows' => '2']) !!} 
                          {!! $errors->first('ket_pembayaran', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div> 
                      <div class="form-group row">
                        <div class="col-md-4">
                          {!! Form::label('photo_pembayaran', 'Bukti Pembayaran') !!}
                          @if($datapembayaran->photo_pembayaran == null)
                            <p>Pasien mengajukan pembayaran secara cash</p>
                          @else
                            <a href="{{asset('images/photo/'.$datapembayaran->photo_pembayaran)}}">
                              <img class="form-control" src="{{asset('images/photo/'.$datapembayaran->photo_pembayaran)}}" style="height:130px; width: 130px;" alt="Bukti Pembayaran">
                            </a>
                          @endif                          
                        </div>
                      </div>
                      <div class="card-footer"> 
                        {!! Form::submit('Simpan', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                        &nbsp;&nbsp;
                        <a class="btn btn-default" href="{{route('pasien.indexpembayaran')}}">Cancel</a>
                        <span class="btn btn-danger" id="btn-tolak">Tolak Pembayaran</span>
                      </div>
                    {!! Form::close() !!}
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
    $('#btn-tolak').on('click', function(e){
      e.preventDefault();
      var id_pembayaran = $("#id_pembayaran").val();
      Swal.fire({
        title: 'Yakin Menolak Pembayaran ini?',
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
          var url = "{{route('admin.tolakpembayaran',['param1'])}}";
          url = url.replace('param1',window.btoa(id_pembayaran));

          $.ajax({
            url      : url,
            type     : 'GET',
            dataType : 'json',
            success: function(_response){
             if(_response.indctr == '1'){      
              Swal.fire('Sukses', _response.msg,'success'
                )
              $('.modal').modal('hide');
              window.location.href = "{{route('admin.indexpembayaran')}}";
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
    })
  });

  function ukem()
  {
    let ubay = $("#uang_bayar").val();
    let ttlhrg = $("#total_tagihan").val();
    let ukem = 0;
    if (ubay < ttlhrg) {
      Swal.fire('Perhatian', 'Nominal Bayar lebih kecil dari total tagihan', 'info'
                );
    } else {
      ukem = Number(ubay) - Number(ttlhrg);
    }
    $("#uang_kembali").val(ukem);
  }
</script>
@endsection
