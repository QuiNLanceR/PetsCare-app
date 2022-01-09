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
              <li class="breadcrumb-item"><a href="{{route('dokter.indexpemeriksaan')}}">Index Pemeriksaan</a></li>
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
                <h3 class="card-title">Pemeriksaan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <!-- form start -->
                    {!! Form::open(['url' => route('dokter.storepemeriksaan'),
                        'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
                      @csrf
                      <div class="form-group row">
                        <div class="col-md-4">
                          {!! Form::label('nm_hewan', 'Nama Hewan') !!}
                          {!! Form::text('nm_hewan', $datapendaftaran->nm_hewan, ['class'=>'form-control','placeholder' => 'Nama Hewan', 'required', 'readonly']) !!} 
                          {!! Form::hidden('id_pendaftaran', $datapendaftaran->id_pendaftaran, ['class'=>'form-control','placeholder' => '', 'required', 'readonly']) !!} 
                          {!! $errors->first('nm_hewan', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('jenis_hewan', 'Jenis Hewan') !!}
                          {!! Form::text('jenis_hewan', $datapendaftaran->jenis_hewan, ['class'=>'form-control','placeholder' => 'Jenis Hewan', 'required', 'readonly']) !!} 
                          {!! $errors->first('jenis_hewan', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('keluhan', 'Keluhan') !!}
                          {!! Form::textarea('keluhan', $datapendaftaran->keluhan, ['class'=>'form-control','placeholder' => 'Keluhan', 'readonly', 'required', 'cols' => '10', 'rows' => '3']) !!} 
                          {!! $errors->first('keluhan', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div> 
                      <div class="form-group row">
                        <div class="col-md-4">
                          {!! Form::label('diagnosis_pemeriksaan', 'Diagnosis') !!}
                          {!! Form::textarea('diagnosis_pemeriksaan', null, ['class'=>'form-control','placeholder' => 'Diagnosis', 'required', 'cols' => '10', 'rows' => '2']) !!} 
                          {!! $errors->first('diagnosis_pemeriksaan', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('tindakan_pemeriksaan', 'Tindakan') !!}
                          {!! Form::textarea('tindakan_pemeriksaan', null, ['class'=>'form-control','placeholder' => 'Tindakan', 'required', 'cols' => '10', 'rows' => '2']) !!} 
                          {!! $errors->first('tindakan_pemeriksaan', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-4">
                          {!! Form::label('harga_pemeriksaan', 'Harga Pemeriksaan') !!}
                          {!! Form::number('harga_pemeriksaan', null, ['class'=>'form-control','placeholder' => 'Harga Pemeriksaan', 'required', 'min' => '0']) !!} 
                          {!! $errors->first('harga_pemeriksaan', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div> 
                      <div class="form-group row">
                        <div class="col-md-12">
                          {!! Form::label('obat', 'Obat ') !!}
                          <span class="btn btn-md btn-primary" id="btn-add"> <i class="fas fa-plus"></i></span><p>*Klik tombol tambah untuk menambahkan obat <br> *Form dibawah tidak perlu diisi jika tidak membutuhkan obat</p>
                        </div>
                      </div> 
                      <div class="form-group row" id="detail-obat">
                        <b>Form Obat</b>
                        <div class="col-md-12" style="border: 1px solid black; padding: 5px;" id="div-detail">
                          <div class="form-group row">
                            <div class="col-md-1">
                              <label for="nomor">No.</label>
                            </div>
                            <div class="col-md-2">
                              <label for="nm_obat">Nama Obat</label>
                            </div>
                            <div class="col-md-2">
                              <label for="nm_obat">Harga Obat</label>
                            </div>
                            <div class="col-md-2">
                              <label for="jumbel">Jumlah Beli</label>
                            </div>
                            <div class="col-md-2">
                              <label for="dosis_obat">Dosis Pemakaian</label>
                            </div>
                            <div class="col-md-2">
                              <label for="total">Total</label>
                            </div>
                            <div class="col-md-1">
                              <label for="total">Action</label>
                            </div>
                          </div>
                          <div class="form-group row" id="divrow-1">
                            <div class="col-md-1">
                              <input type="text" value="1" readonly name="number[]" id="number-1" class="form-control">
                            </div>
                            <div class="col-md-2">
                              <select name="id_obat[]" onchange="getharga(this.id)" id="id_obat-1" class="form-control">
                                <option value="">~ Pilih ~</option>
                                @foreach($dataobat as $val)
                                  <option value="{{$val->id_obat}}">{{$val->nm_obat}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-2">
                              <input type="number" class="form-control" placeholder="Harga Obat" readonly id="harga_obat-1" name="harga_obat[]">
                            </div>
                            <div class="col-md-2">
                              <input type="number" class="form-control" placeholder="Jumlah Beli" onchange="totharga(this.id)" id="jml_obat-1" name="jml_obat[]">
                            </div>
                            <div class="col-md-2">
                              <input type="text" class="form-control" placeholder="Dosis Obat" id="dosis_obat-1" name="dosis_obat[]">
                            </div>
                            <div class="col-md-2">
                              <input type="number" class="form-control" placeholder="Total" readonly id="total-1" name="total[]">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-7"></div>
                        <div class="col-md-2">Total Bayar Obat</div>
                        <div class="col-md-2">
                          <input type="number" readonly name="total_bayar" placeholder="Total Bayar" id="total_bayar" class="form-control">
                        </div>
                      </div>  
                      <div class="card-footer"> 
                        {!! Form::submit('Simpan', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                        &nbsp;&nbsp;
                        <a class="btn btn-default" href="{{route('dokter.indexpemeriksaan')}}">Cancel</a>
                      </div>
                      <input type="hidden" id="kontrol" name="kontrol" value="y">
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
    $('#btn-add').on('click', function(e){
      e.preventDefault();
      counter = $('[id^=divrow-]').length + 1;
      $("#div-detail").append(`
        <div class="form-group row" id="divrow-${counter}">
          <div class="col-md-1">
            <input type="text" value="${counter}" readonly name="number[]" id="number-${counter}" class="form-control">
          </div>
          <div class="col-md-2">
            <select name="id_obat[]" onchange="getharga(this.id)" id="id_obat-${counter}" class="form-control">
              <option value="">~ Pilih ~</option>
              @foreach($dataobat as $val)
                <option value="{{$val->id_obat}}">{{$val->nm_obat}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <input type="number" class="form-control" placeholder="Harga Obat" readonly id="harga_obat-${counter}" name="harga_obat[]">
          </div>
          <div class="col-md-2">
            <input type="number" onchange="totharga(this.id)" class="form-control" placeholder="Jumlah Beli" id="jml_obat-${counter}" name="jml_obat[]">
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" placeholder="Dosis Obat" id="dosis_obat-${counter}" required name="dosis_obat[]">
          </div>
          <div class="col-md-2">
            <input type="number" class="form-control" placeholder="Total" readonly id="total-${counter}" name="total[]">
          </div>
          <div class="col-md-1">
            <span class="btn btn-md btn-danger" id="btn-delrow-${counter}" onclick="hapusrow(this.id)"> <i class="fas fa-trash" title="Hapus"></i></span>
          </div>
        </div>
      `)
    });
    $("#btn-save").on('click', function(e){
      e.preventDefault(); 
      Swal.fire({
        title: 'Apakah pasien ini memerlukan kontrol lanjutan?',
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
          $('#form_id').submit();
        } else if (result.isDismissed) {
          $('#kontrol').val('t');
          $('#form_id').submit();
        }
      })
    });
  });


  function hapusrow(id){
    var ths = id.replace("btn-delrow-", "");
    var jml_row = $('[id^=divrow-]').length;

    var id_row = "#divrow-" + ths;
    $(id_row).remove();

    jml_row = Number(jml_row);
    let nextRow = Number(jml_row) + 1;
    for(let i = 2; i <= nextRow; i++) {
        var row = "#divrow-" + i;
        var row_new = "divrow-" + (i-1);
        $(row).attr({"id":row_new});
        var number = "#number-" + i;
        var number_new = "number-" + (i-1);
        $(number).attr({"id":number_new});
        $('#'+number_new).val(i-1).trigger('change');
        var id_obat = "#id_obat-" + i;
        var id_obat_new = "id_obat-" + (i-1);
        $(id_obat).attr({"id":id_obat_new});
        var harga_obat = "#harga_obat-" + i;
        var harga_obat_new = "harga_obat-" + (i-1);
        $(harga_obat).attr({"id":harga_obat_new});
        var jml_obat = "#jml_obat-" + i;
        var jml_obat_new = "jml_obat-" + (i-1);
        $(jml_obat).attr({"id":jml_obat_new});
        var dosis_obat = "#dosis_obat-" + i;
        var dosis_obat_new = "dosis_obat-" + (i-1);
        $(dosis_obat).attr({"id":dosis_obat_new});
        var total = "#total-" + i;
        var total_new = "total-" + (i-1);
        $(total).attr({"id":total_new});
        var delrow = "#btn-delrow-" + i;
        var delrow_new = "btn-delrow-" + (i-1);
        $(delrow).attr({"id":delrow_new});
    }
  }

  function getharga(id){
    let no = id.replace('id_obat-','');
    let valueid = $('#'+id).val(); 
    let url = "{{route('dokter.getharga','param1')}}";
    url = url.replace('param1', window.btoa(valueid));
    $.get(url, function(_response){
      $('#harga_obat-'+no).val(_response);
    });
  }

  function totharga(id){
    let no = id.replace('jml_obat-','');
    let valharga = $("#harga_obat-"+no).val();
    let valjumbel = $("#jml_obat-"+no).val();
    let ttl = Number(valharga) * Number(valjumbel);
    $('#total-'+no).val(ttl);
    totkeseluruhan();
  }

  function totkeseluruhan(){
    let jml_row = $('[id^=divrow-]').length;
    let hrg = 0;
    for (let i = 1; i <= jml_row; i++) {
      hrg += Number($('#total-'+i).val());
    }

    $("#total_bayar").val(hrg);
  }
</script>
@endsection
