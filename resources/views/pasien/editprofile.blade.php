@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active">Pemilik Hewan Profile</li>
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
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  @if($data->photo_pasien == null)
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{asset('images/no_image.png')}}"
                         alt="User profile picture">                    
                  @else
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{asset('images/photo/'.$data->photo_pasien)}}"
                         alt="User profile picture">
                  @endif
                </div>

                <h3 class="profile-username text-center">{{$data->nm_pasien}}</h3>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#" data-toggle="tab">Profile</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="email_pasien">Email: </label>
                        <span>{{$data->email_pasien}}</span>
                      </div>
                      <div class="col-md-6">
                        <label for="NIK">NIK Pemilik Hewan: </label>
                        <span>{{$data->nik_pasien}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="ttl">Tempat, Tanggal Lahir: </label>
                        <span>{{$data->tmp_lah_pasien . ', ' . $data->tgl_lah_pasien}}</span>
                      </div>
                      <div class="col-md-6">
                        <label for="jen_kel_pasien">Jenis Kelamin: </label>
                        <span>{{$data->jen_kel_pasien == 'p' ? 'Perempuan' : 'Laki-Laki'}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="no_hp_pasien">No Handphone: </label>
                        <span>{{$data->no_hp_pasien}}</span>
                      </div>
                      <div class="col-md-6">
                        <label for="no_hp_pasien">Alamat: </label>
                        <span>{{$data->alamat_pasien}}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <span class="btn btn-md btn-success" id="btn-edit"><i class="fas fa-edit"></i> Edit Profile</span>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('pasien.updateprofile',base64_encode($data->nik_pasien))}}" method="post" enctype="multipart/form-data" id="form_id" class="form-horizontal">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <label for="nm_pasien">Nama</label>
                <input type="text" name="nm_pasien" value="{{$data->nm_pasien}}" placeholder="Nama Pemilik Hewan" class="form-control" id="nm_pasien">
                <input type="hidden" name="nik_pasien" value="{{$data->nik_pasien}}" class="form-control" readonly id="nik_pasien">
                <input type="hidden" name="email_pasien" value="{{$data->email_pasien}}" placeholder="Email Pemilik Hewan" readonly class="form-control" id="email_pasien">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="tmp_lah_pasien">Tempat Lahir</label>
                <input type="text" value="{{$data->tmp_lah_pasien}}" name="tmp_lah_pasien" placeholder="Tempat Lahir Pemilik Hewan" class="form-control" id="tmp_lah_pasien">
              </div>
              <div class="col-md-6">
                <label for="tgl_lah_pasien">Tanggal Lahir</label>
                <input type="date" value="{{$data->tgl_lah_pasien}}" name="tgl_lah_pasien" placeholder="Tempat Lahir Pemilik Hewan" class="form-control" id="tgl_lah_pasien">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="no_hp_pasien">No Handphone</label>
                <input type="number" value="{{$data->no_hp_pasien}}" name="no_hp_pasien" placeholder="No Handphone Pemilik Hewan" class="form-control" id="no_hp_pasien">
              </div>
              <div class="col-md-6">
                <label for="photo_pasien">Photo</label>
                <input type="file" id="photo_pasien" name="photo_pasien" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="jen_kel_pasien">Jenis Kelamin</label>
                <select name="jen_kel_pasien" id="jen_kel_pasien" class="form-control">
                  <option value="p" {{$data->jen_kel_pasien == 'p' ? 'selected' : ''}}>Perempuan</option>
                  <option value="l" {{$data->jen_kel_pasien == 'l' ? 'selected' : ''}}>Laki-Laki</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="jen_kel_pasien">Alamat Pemilik Hewan</label>
                <textarea name="alamat_pasien" id="alamat_pasien" class="form-control" cols="3" rows="2">{{$data->alamat_pasien}}</textarea>
              </div>
            
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary" id="btn-simpan">Ubah</button>
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
  $(document).ready(function(){
    $("#btn-edit").on('click', function(e){
      e.preventDefault();
      $("#modal-edit").modal('show');
    });
    $("#btn-simpan").on('click', function(e){
      e.preventDefault();
      simpandata();
    });
  });

  function simpandata()
  {
    if ($("#email_pasien").val() != '') {
      if ($("#nik_pasien").val() != '') {
        if ($("#nm_pasien").val() != '') {
          $("#form_id").submit();
        }else {
          Swal.fire('Perhatian!','Harap isi field Nama!','warning');
        }
      } else {
        Swal.fire('Perhatian!','Harap isi field Username!','warning');
      }
    } else {
      Swal.fire('Perhatian!','Harap isi field Email!','warning');
    }
  }
</script>
@endsection
