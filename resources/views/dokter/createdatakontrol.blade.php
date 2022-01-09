@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Data Kontrol</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item">Transaksi</li>
              <li class="breadcrumb-item"><a href="{{route('dokter.indexpemeriksaan')}}">Pemeriksaan</a></li>
              <li class="breadcrumb-item active">Create Data Kontrol</li>
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
                <h3 class="card-title">Create Data Kontrol</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <!-- form start -->
                    {!! Form::open(['url' => route('dokter.storedatakontrol'),
                        'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
                       @csrf
                       <div class="form-group row">
                        <div class="col-md-4">
                          {!! Form::label('nm_pasien', 'Nama Pasien') !!}
                          {!! Form::text('nm_pasien', $data->nm_pasien, ['class'=>'form-control', 'placeholder' => 'Nama Pasien', 'required', 'readonly']) !!} 
                          {!! Form::hidden('id_kontrols', $data->id_kontrols, ['class'=>'form-control', 'placeholder' => 'Nama Pasien', 'required', 'readonly']) !!} 
                          {!! Form::hidden('id_pemeriksaan', $data->id_pemeriksaan, ['class'=>'form-control', 'placeholder' => 'Nama Pasien', 'required', 'readonly']) !!} 
                          {!! $errors->first('nm_pasien', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('nm_hewan', 'Nama Hewan') !!}
                          {!! Form::text('nm_hewan', $data->nm_hewan, ['class'=>'form-control', 'placeholder' => 'Nama Hewan', 'required', 'readonly']) !!} 
                          {!! $errors->first('nm_hewan', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('diagnosis_pemeriksaan', 'Diagnosis') !!}
                          {!! Form::textarea('diagnosis_pemeriksaan', $data->diagnosis_pemeriksaan, ['class'=>'form-control', 'placeholder' => 'Diagnosis', 'required', 'cols' => '10', 'rows' => '2', 'readonly']) !!} 
                          {!! $errors->first('diagnosis_pemeriksaan', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div> 
                      <div class="form-group row">
                       <div class="col-md-4">
                         {!! Form::label('tgl_pemeriksaan', 'Tanggal Pemeriksaan') !!}
                         {!! Form::text('tgl_pemeriksaan', $data->tgl_pemeriksaan, ['class'=>'form-control', 'placeholder' => 'Tanggal Pemeriksaan', 'required', 'readonly']) !!} 
                         {!! $errors->first('tgl_pemeriksaan', '<p class="help-block">:message</p>') !!}
                       </div>
                       <div class="col-md-4">
                         {!! Form::label('tindakan_kontrol', 'Tindakan Kontrol') !!}
                         {!! Form::textarea('tindakan_kontrol', $data->tindakan_kontrol, ['class'=>'form-control', 'placeholder' => 'Tindakan Kontrol', 'required', 'cols' => '10', 'rows' => '2']) !!} 
                         {!! $errors->first('tindakan_kontrol', '<p class="help-block">:message</p>') !!}
                       </div>
                     </div> 
                      <div class="card-footer"> 
                        {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                        &nbsp;&nbsp;
                        <a class="btn btn-default" href="{{route('dokter.indexdatakontrol')}}">Cancel</a>
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
