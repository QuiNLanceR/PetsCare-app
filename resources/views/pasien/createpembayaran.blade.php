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
                <h3 class="card-title">Form Pembayaran <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-notif"> <i class="fas fa-info"></i>
                 </button></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <!-- form start -->
                    {!! Form::open(['url' => route('pasien.storepembayaran'),
                        'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
                       @csrf
                       <div class="form-group row">
                        <div class="col-md-4">
                          {!! Form::label('photo_pembayaran', 'Bukti Pembayaran') !!}
                          {!! Form::file('photo_pembayaran', null, ['class'=>'form-control','placeholder' => 'Bukti Pembayaran']) !!} 
                          {!! Form::hidden('id_pembayaran', $datapembayaran->id_pembayaran, ['class'=>'form-control','placeholder' => 'Nama', 'required', 'readonly']) !!} 
                          {!! $errors->first('photo_pembayaran', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div> 
                      <div class="card-footer"> 
                        {!! Form::submit('Simpan', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                        &nbsp;&nbsp;
                        <a class="btn btn-default" href="{{route('pasien.indexpembayaran')}}">Cancel</a>
                        <p>* Isi bukti pembayaran jika pembayaran menggunakan e-money atau uang elektronik atau dapat langsung klik simpan untuk pembayaran secara cash</p>
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
            Pembayaran via e-money dapat dilakukan melalui beberapa aplikasi berikut:
          </p>
          <br>
          <label for="Bank Account">Bank Account</label>
          <div class="row">
            <div class="col-md-6"><label for="Bank Mandiri">Bank Mandiri</label>
              <img src="{{asset('images/logo-mandiri.png')}}" alt="" style="width:155px;height: 60px;" alt="Logo App"> <br><p>No: 82139988123 <br> a/n Puskeswan</p></div>
            <div class="col-md-6"><label for="Bank BCA">Bank BCA</label>
              <img src="{{asset('images/logo-bca.png')}}" alt="" style="width:155px;height: 60px;" alt="Logo App"> <br><p>No: 8821321344 <br> a/n Puskeswan</p></div>
          </div>
          <br>
          <label for="E-Money Account">E-Money Account</label>
          <div class="row">
            <div class="col-md-3"><label for="Gopay">Gopay</label>
              <img src="{{asset('images/logo-gopay.jpg')}}" alt="" style="width:100px;height: 45px;" alt="Logo App"> <br><p>No: 0813213141242 <br> a/n Puskeswan</p></div>
            <div class="col-md-3"><label for="Ovo">Ovo</label>
              <img src="{{asset('images/logo-ovo.png')}}" alt="" style="width:100px;height: 45px;" alt="Logo App"> <br><p>No: 0813213141242 <br> a/n Puskeswan</p></div>
            <div class="col-md-3"><label for="Shopee Pay">Shopee Pay</label>
              <img src="{{asset('images/logo-shopeepay.jpg')}}" alt="" style="width:100px;height: 45px;" alt="Logo App"> <br><p>No: 0813213141242 <br> a/n Puskeswan</p></div>
            <div class="col-md-3"><label for="Dana">Dana</label>
              <img src="{{asset('images/logo-dana.jpg')}}" alt="" style="width:100px;height: 45px;" alt="Logo App"> <br><p>No: 0813213141242 <br> a/n Puskeswan</p></div>
          </div>
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
@endsection
@section('scripts')
<script>
</script>
@endsection
