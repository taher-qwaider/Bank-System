@extends('cms.parent')
@section('title', 'Create Rloe')

@section('page-title', 'Rloe')
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
              <h3 class="card-title">Create Roles</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_role">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label>Gard :</label>
                    <select class="form-control gards" id="gards" style="width: 100%;">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                    </select>
                  </div>
                <div class="form-group">
                <label for="name">Role Name :</label>
                <input type="text" class="form-control" id="role" placeholder="Enter Role Name">
                </div>
              </div>

              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performSave()" class="btn btn-primary">Save</button>
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
        $('.gards').select2({
        theme: 'bootstrap4'
        });
    </script>
    <script>
        function performSave(){
            axios.post('/cms/admin/roles', {
            gard: document.getElementById('gards').value,
            name: document.getElementById('role').value,
        })
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            document.getElementById('create_role').reset();
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
