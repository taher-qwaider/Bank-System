@extends('cms.parent')
@section('title', 'Create User Debits')

@section('page-title', 'User Debits')
@section('home-page', 'Home')
@section('sub-page', 'User Debits')

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
              <h3 class="card-title">Create User Debits</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_user_debits">
                @csrf
              <div class="card-body">

                <div class="form-group">
                    <label for="first_name">First Name :</label>
                    <input type="text" class="form-control" id="first_name" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label for="last_name">last Name :</label>
                    <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile :</label>
                    <input type="number" class="form-control" id="mobile" placeholder="Enter mobile">
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone :</label>
                    <input type="tel" class="form-control" id="telephone"  placeholder="Enter Telephone">
                </div>
                <div class="form-group">
                    <label for="address">Address :</label>
                    <input type="text" class="form-control" id="address"  placeholder="Enter Address">
                </div>
                <div class="col-sm-6">
                    <label>Gender :</label>
                    <div class="form-group">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="male" name="gender">
                        <label for="male">Male
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="female" name="gender">
                        <label for="female">
                          Female
                        </label>
                      </div>
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
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        function performSave(){
            axios.post('/cms/user/debts-user', {
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            mobile: document.getElementById('mobile').value,
            telephone: document.getElementById('telephone').value,
            address: document.getElementById('address').value,
            gender: document.getElementById('male').checked ? 'M' : "F",
        })
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            document.getElementById('create_user_debits').reset();
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
