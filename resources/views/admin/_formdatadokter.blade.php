<div class="form-group row">
  <div class="col-md-4">
    {!! Form::label('nm_dokter', 'Nama') !!}
    {!! Form::text('nm_dokter', null, ['class'=>'form-control','placeholder' => 'Nama', 'required']) !!} 
    {!! $errors->first('nm_dokter', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-4">
    {!! Form::label('email_dokter', 'Email') !!}
    {!! Form::email('email_dokter', null, ['class'=>'form-control','placeholder' => 'Email', empty($datadokter->id_dokter) ? '' : 'readonly', 'required']) !!} 
    {!! $errors->first('email_dokter', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-4">
    {!! Form::label('username', 'Username') !!}
    {!! Form::text('username', null, ['class'=>'form-control','placeholder' => 'Username', empty($datadokter->id_dokter) ? '' : 'readonly', 'required']) !!} 
    {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
  </div>
</div> 
<div class="form-group row">
  <div class="col-md-4">
    {!! Form::label('tmp_lah_dokter', 'Tempat Lahir') !!}
    {!! Form::text('tmp_lah_dokter', null, ['class'=>'form-control','placeholder' => 'Tempat Lahir', 'required']) !!} 
    {!! $errors->first('tmp_lah_dokter', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-4">
    {!! Form::label('tgl_lah_dokter', 'Tanggal Lahir') !!}
    {!! Form::date('tgl_lah_dokter', null, ['class'=>'form-control','placeholder' => 'Tanggal Lahir', 'required']) !!} 
    {!! $errors->first('tgl_lah_dokter', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-4">
    {!! Form::label('jen_kel_dokter', 'Jenis Kelamin') !!}
    {!! Form::select('jen_kel_dokter', array('' => '~ Pilih ~', 'l' => 'Laki-Laki', 'p' => 'Perempuan'), null,['class'=>'form-control select2', 'required']) !!} 
    {!! $errors->first('jen_kel_dokter', '<p class="help-block">:message</p>') !!}
  </div>
</div> 
<div class="form-group row">
  <div class="col-md-4">
    {!! Form::label('no_hp_dokter', 'No Handphone') !!}
    {!! Form::number('no_hp_dokter', null, ['class'=>'form-control','placeholder' => 'No Handphone', 'required']) !!} 
    {!! $errors->first('no_hp_dokter', '<p class="help-block">:message</p>') !!}
  </div>
  @if (empty($datadokter->id_dokter))
  <div class="col-md-4">
    {!! Form::label('password', 'Password') !!}
    {!! Form::text('password', null, ['class'=>'form-control','placeholder' => 'Password', 'required']) !!} 
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
  </div>
  @endif
  <div class="col-md-4">
    {!! Form::label('photo_dokter', 'Photo Dokter') !!}
    {!! Form::file('photo_dokter', null, ['class'=>'form-control','placeholder' => 'Photo Dokter', 'accept' => 'image/*']) !!} 
    {!! $errors->first('photo_dokter', '<p class="help-block">:message</p>') !!}
  </div>
</div> 
<div class="card-footer"> 
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($datadokter->id_dokter))
  {!! Form::button('Delete', ['class'=>'btn btn-danger', 'onclick' => 'hapusdata("'.base64_encode($datadokter->id_dokter).'","'.base64_encode($datadokter->username).'")', 'id' => 'btn-delete']) !!}
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{route('admin.indexdatadokter')}}">Cancel</a>
</div>
@section('scripts')
<script type="text/javascript">
function hapusdata(id,username)
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
      var url = "{{route('admin.deletedatadokter',['param1','param2'])}}";
      url = url.replace('param1',id);
      url = url.replace('param2',username);

      $.ajax({
        url      : url,
        type     : 'GET',
        dataType : 'json',
        success: function(_response){
         if(_response.indctr == '1'){      
          Swal.fire('Sukses', _response.msg,'success'
            )
          $('.modal').modal('hide');
          window.location.href = "{{route('admin.indexdatadokter')}}";
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