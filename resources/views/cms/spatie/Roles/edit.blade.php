@extends('cms.parent')
@section('title', 'Updata Admin')

@section('page-title', 'Updata Role')
@section('home-page', 'Home')
@section('sub-page', 'Role')

@section('styles')
      <!-- Select2 -->
      <link rel="stylesheet" href="{{ asset('cms/plugins/select2/css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Role</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_admin">
                @csrf
              <div class="card-body">
                    <div class="form-group">
                        <label>Gard :</label>
                        <select class="form-control guards" id="guard" style="width: 100%;">
                                <option value="admin" @if ($role->guard_name == "admin") selected @endif>Admin</option>
                                <option value="user" @if ($role->guard_name == "user") selected @endif>User</option>
                        </select>
                      </div>
                    <div class="form-group">
                    <label for="name">Role Name :</label>
                    <input type="text" class="form-control" value="{{ $role->name }}" id="name" placeholder="Enter Role Name">
                    </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performupdata({{ $role->id }})" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.guards').select2({
        theme: 'bootstrap4'
        });
    </script>
    <script>
        function performupdata(id){
            axios.put('/cms/admin/roles/'+id, {
            guard: document.getElementById('guard').value,
            name: document.getElementById('name').value,
        })
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            window.location.href='{{ route('roles.index') }}';
        })
        .catch(function (error) {
            console.log(error);
            showConfirm(error.response.data.message, false);
        });
        }
        function showConfirm(massege, status){
            if(status){
                toastr.success(massege);
            }else{
                toastr.error(massege);
            }
        }
    </script>
@endsection
