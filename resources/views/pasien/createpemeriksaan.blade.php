@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ambil Antrian</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item">Transaksi</li>
              <li class="breadcrumb-item"><a href="{{route('pasien.indexpemeriksaan')}}">Pemeriksaan</a></li>
              <li class="breadcrumb-item active">Ambil Antrian</li>
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
                <h3 class="card-title">Form Ambil Antrian</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <!-- form start -->
                    {!! Form::open(['url' => route('pasien.storepemeriksaan'),
                        'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
                       @csrf
                       <div class="form-group row">
                        <div class="col-md-4">
                          {!! Form::label('nm_hewan', 'Nama Hewan Peliharaan') !!}
                          {!! Form::text('nm_hewan', null, ['class'=>'form-control','placeholder' => 'Nama', 'required']) !!} 
                          {!! $errors->first('nm_hewan', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                          {!! Form::label('keluhan', 'Keluhan') !!}
                          <textarea name="keluhan" id="keluhan" cols="3" rows="2" placeholder="Keluhan" class="form-control"></textarea>
                          {!! $errors->first('keluhan', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div> 
                      <div class="card-footer"> 
                        {!! Form::submit('Simpan', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                        &nbsp;&nbsp;
                        <a class="btn btn-default" href="{{route('pasien.indexpemeriksaan')}}">Cancel</a>
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
