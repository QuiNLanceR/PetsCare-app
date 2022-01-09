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
              <li class="breadcrumb-item active">Admin Profile</li>
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
                  @if($data->photo_admin == null)
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{asset('images/no_image.png')}}"
                         alt="User profile picture">                    
                  @else
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{asset('images/photo/'.$data->photo_admin)}}"
                         alt="User profile picture">
                  @endif
                </div>

                <h3 class="profile-username text-center">{{$data->nm_admin}}</h3>
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
                        <label for="email_admin">Email: </label>
                        <span>{{$data->email_admin}}</span>
                      </div>
                      <div class="col-md-6">
                        <label for="username">Username: </label>
                        <span>{{$data->username}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="ttl">Tempat, Tanggal Lahir: </label>
                        <span>{{$data->tmp_lah_admin . ', ' . $data->tgl_lah_admin}}</span>
                      </div>
                      <div class="col-md-6">
                        <label for="jen_kel_admin">Jenis Kelamin: </label>
                        <span>{{$data->jen_kel_admin == 'p' ? 'Perempuan' : 'Laki-Laki'}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="no_hp_admin">No Handphone: </label>
                        <span>{{$data->no_hp_admin}}</span>
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
          <form action="{{route('admin.updateprofile',base64_encode($data->id_admin))}}" method="post" enctype="multipart/form-data" id="form_id" class="form-horizontal">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <label for="nm_admin">Nama</label>
                <input type="text" name="nm_admin" value="{{$data->nm_admin}}" placeholder="Nama Admin" class="form-control" id="nm_admin">
                <input type="hidden" name="id_admin" value="{{$data->id_admin}}" class="form-control" readonly id="id_admin">
                <input type="hidden" name="email_admin" value="{{$data->email_admin}}" placeholder="Email Admin" readonly class="form-control" id="email_admin">
                <input type="hidden" value="{{$data->username}}" name="username" placeholder="Username Admin" readonly class="form-control" id="username">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="tmp_lah_admin">Tempat Lahir</label>
                <input type="text" value="{{$data->tmp_lah_admin}}" name="tmp_lah_admin" placeholder="Tempat Lahir Admin" class="form-control" id="tmp_lah_admin">
              </div>
              <div class="col-md-6">
                <label for="tgl_lah_admin">Tanggal Lahir</label>
                <input type="date" value="{{$data->tgl_lah_admin}}" name="tgl_lah_admin" placeholder="Tempat Lahir Admin" class="form-control" id="tgl_lah_admin">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="no_hp_admin">No Handphone</label>
                <input type="number" value="{{$data->no_hp_admin}}" name="no_hp_admin" placeholder="No Handphone Admin" class="form-control" id="no_hp_admin">
              </div>
              <div class="col-md-6">
                <label for="photo_admin">Photo</label>
                <input type="file" id="photo_admin" name="photo_admin" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="jen_kel_admin">Jenis Kelamin</label>
                <select name="jen_kel_admin" id="jen_kel_admin" class="form-control">
                  <option value="p" {{$data->jen_kel_admin == 'p' ? 'selected' : ''}}>Perempuan</option>
                  <option value="l" {{$data->jen_kel_admin == 'l' ? 'selected' : ''}}>Laki-Laki</option>
                </select>
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
    if ($("#email_admin").val() != '') {
      if ($("#username").val() != '') {
        if ($("#nm_admin").val() != '') {
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
