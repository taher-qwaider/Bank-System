@extends('cms.parent')
@section('title', 'Change password')

@section('page-title', 'Change password')
@section('home-page', 'Home')
@section('sub-page', 'Change password')

@section('styles')
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
              <h3 class="card-title">Change password</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="change_password">
                @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="current_password">Current password</label>
                  <input type="password" class="form-control" id="current_password" placeholder="Enter current password">
                </div>
                <div class="form-group">
                    <label for="new_password">new password</label>
                    <input type="password" class="form-control" id="new_password" placeholder="Enter new password">
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">new password Confirmation</label>
                    <input type="password" class="form-control" id="new_password_confirmation" placeholder="Enter new password confirmation">
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="changePassword()" class="btn btn-primary">Change</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        function changePassword(){
            axios.put('/cms/admin/updata-password', {
            current_password: document.getElementById('current_password').value,
            new_password: document.getElementById('new_password').value,
            new_password_confirmation: document.getElementById('new_password_confirmation').value,
        })
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            document.getElementById('change_password').reset();
        })
        .catch(function (error) {
            console.log(error.response);
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
