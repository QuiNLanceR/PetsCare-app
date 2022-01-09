@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Rujukan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item">Transaksi</li>
              <li class="breadcrumb-item"><a href="{{route('dokter.indexpemeriksaan')}}">Pemeriksaan</a></li>
              <li class="breadcrumb-item active">Create Rujukan</li>
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
                <h3 class="card-title">Create Rujukan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <!-- form start -->
                    {!! Form::open(['url' => route('dokter.storerujukan'),
                        'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
                       @csrf
                       <div class="form-group row">
                        <div class="col-md-4">
                          {!! Form::label('lok_tujuan', 'Lokasi Tujuan') !!}
                          {!! Form::text('lok_tujuan', null, ['class'=>'form-control', 'placeholder' => 'Lokasi Tujuan', 'required']) !!} 
                          {!! Form::hidden('id_pendaftaran', $datapendaftaran->id_pendaftaran, ['class'=>'form-control','placeholder' => 'No Pendaftaran', 'required', 'readonly']) !!} 
                          {!! $errors->first('', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('alamat_tujuan', 'Alamat Tujuan') !!}
                          {!! Form::textarea('alamat_tujuan', null, ['class'=>'form-control','placeholder' => 'Alamat Tujuan', 'required', 'cols' => '10', 'rows' => '2']) !!} 
                          {!! $errors->first('alamat_tujuan', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('ket_rujukan', 'Keterangan Rujukan') !!}
                          {!! Form::textarea('ket_rujukan', null, ['class'=>'form-control','placeholder' => 'Keterangan Rujukan', 'required', 'cols' => '10', 'rows' => '2']) !!} 
                          {!! $errors->first('ket_rujukan', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div> 
                      <div class="card-footer"> 
                        {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                        &nbsp;&nbsp;
                        <a class="btn btn-default" href="{{route('dokter.indexpemeriksaan')}}">Cancel</a>
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
<script type="text/javascript">
  $(document).ready(function(){
      
  });
</script>
@endsection
