@extends('cms.parent')
@section('title', 'Permissions')


@section('page-title', 'Permissions')
@section('home-page', 'home')
@section('sub-page', 'Permissions')
@section('styles')
    <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Permissions</h3>

                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover table-bordered text-nowrap">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Guard</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <span class="badge bg-info">{{ $permission->guard_name }}</span>
                            </td>
                            <td>
                                <div class="icheck-success d-inline">
                                    <input type="checkbox" id="permission_{{ $permission->id }}" onclick="store({{ $roleId }}, {{ $permission->id }})"
                                    @if($permission->active)
                                    checked
                                    @endif
                                    >
                                    <label for="permission_{{ $permission->id }}">
                                    </label>
                                </div>
                            </td>
                        </tr>
                          @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
@endsection

@section('scripts')
         <!-- Toastr -->
        <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        function store(id, permission_id){
            axios.post('/cms/admin/Role/'+id+'/Permissions', {
                permission_id:permission_id,
            })
            .then(function (response) {
                // handle success
                console.log(response.data);
                responsAlert(response.data.message, true);
            })
            .catch(function (error) {
                // handle error
                console.log(error.response.data);
                responsAlert(error.response.data.message, false);
            })
        }

        function responsAlert(data, status){
            if(status){
                toastr.success(data);
            }else{
                toastr.error(data);
            }

        }
    </script>
@endsection
