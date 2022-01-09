<div class="form-group row">
  <div class="col-md-4">
    {!! Form::label('nm_pasien', 'Nama') !!}
    {!! Form::text('nm_pasien', null, ['class'=>'form-control','placeholder' => 'Nama', 'required']) !!} 
    {!! $errors->first('nm_pasien', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-4">
    {!! Form::label('email_pasien', 'Email') !!}
    {!! Form::email('email_pasien', null, ['class'=>'form-control','placeholder' => 'Email', empty($datapasien->nik_pasien) ? '' : 'readonly', 'required']) !!} 
    {!! $errors->first('email_pasien', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-4">
    {!! Form::label('nik_pasien', 'NIK') !!}
    {!! Form::number('nik_pasien', null, ['class'=>'form-control','placeholder' => 'NIK', empty($datapasien->nik_pasien) ? '' : 'readonly', 'required']) !!} 
    {!! $errors->first('nik_pasien', '<p class="help-block">:message</p>') !!}
  </div>
</div> 
<div class="form-group row">
  <div class="col-md-4">
    {!! Form::label('tmp_lah_pasien', 'Tempat Lahir') !!}
    {!! Form::text('tmp_lah_pasien', null, ['class'=>'form-control','placeholder' => 'Tempat Lahir', 'required']) !!} 
    {!! $errors->first('tmp_lah_pasien', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-4">
    {!! Form::label('tgl_lah_pasien', 'Tanggal Lahir') !!}
    {!! Form::date('tgl_lah_pasien', null, ['class'=>'form-control','placeholder' => 'Tanggal Lahir', 'required']) !!} 
    {!! $errors->first('tgl_lah_pasien', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-4">
    {!! Form::label('jen_kel_pasien', 'Jenis Kelamin') !!}
    {!! Form::select('jen_kel_pasien', array('' => '~ Pilih ~', 'l' => 'Laki-Laki', 'p' => 'Perempuan'), null,['class'=>'form-control select2', 'required']) !!} 
    {!! $errors->first('jen_kel_pasien', '<p class="help-block">:message</p>') !!}
  </div>
</div> 
<div class="form-group row">
  <div class="col-md-4">
    {!! Form::label('no_hp_pasien', 'No Handphone') !!}
    {!! Form::number('no_hp_pasien', null, ['class'=>'form-control','placeholder' => 'No Handphone', 'required']) !!} 
    {!! $errors->first('no_hp_pasien', '<p class="help-block">:message</p>') !!}
  </div>
  @if (empty($datapasien->nik_pasien))
  <div class="col-md-4">
    {!! Form::label('password', 'Password') !!}
    {!! Form::text('password', null, ['class'=>'form-control','placeholder' => 'Password', 'required']) !!} 
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
  </div>
  @endif
  <div class="col-md-4">
    {!! Form::label('photo_pasien', 'Photo Pasien') !!}
    {!! Form::file('photo_pasien', null, ['class'=>'form-control','placeholder' => 'Photo Pasien', 'accept' => 'image/*']) !!} 
    {!! $errors->first('photo_pasien', '<p class="help-block">:message</p>') !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4">
    {!! Form::label('alamat_pasien', 'Alamat') !!}
    {!! Form::textarea('alamat_pasien', null, ['class'=>'form-control','placeholder' => 'Alamat', 'cols' => '20', 'rows' => '3']) !!} 
    {!! $errors->first('alamat_pasien', '<p class="help-block">:message</p>') !!}
  </div>
</div> 
<div class="card-footer"> 
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($datapasien->nik_pasien))
  {!! Form::button('Delete', ['class'=>'btn btn-danger', 'onclick' => 'hapusdata("'.base64_encode($datapasien->nik_pasien).'")', 'id' => 'btn-delete']) !!}
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{route('admin.indexdatapasien')}}">Cancel</a>
</div>
@section('scripts')
<script type="text/javascript">
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
          window.location.href = "{{route('admin.indexdatapasien')}}";
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

  $(document).ready(function(){
      
  });
</script>
@endsection