@extends('cms.parent')
@section('title', 'Create User')

@section('page-title', 'User')
@section('home-page', 'Home')
@section('sub-page', 'User')

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
              <h3 class="card-title">Create User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_user">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label>City :</label>
                    <select class="form-control cities" id="city" style="width: 100%;">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Profession :</label>
                    <select class="form-control cities" id="profession" style="width: 100%;">
                        @foreach ($professions as $profession)
                            <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="form-group">
                <label for="first_name">First Name :</label>
                <input type="text" class="form-control" id="first_name" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name :</label>
                    <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                    <label for="user-image">Your Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="user-image">
                        <label class="custom-file-label" for="user-image">Choose Image</label>
                      </div>
                    </div>
                  </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile :</label>
                    <input type="tel" class="form-control" id="mobile"  placeholder="Enter mobile">
                </div>
                <div class="form-group">
                    <label for="id_number">ID Number :</label>
                    <input type="number" class="form-control" id="id_number"  placeholder="Enter ID Number">
                </div>
                <div class="col-sm-6">
                    <!-- radio -->
                    <label>Gender :</label>
                    <div class="form-group clearfix">
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
    <!-- bs-custom-file-input -->
    <script src="{{ asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.cities').select2({
        theme: 'bootstrap4'
        });

        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        function performSave(){
            var formData=new FormData();
            formData.append('first_name', document.getElementById('first_name').value);
            formData.append('last_name', document.getElementById('last_name').value);
            formData.append('image', document.getElementById('user-image').files[0]);
            formData.append('email', document.getElementById('email').value);
            formData.append('mobile', document.getElementById('mobile').value);
            formData.append('city_id', document.getElementById('city').value);
            formData.append('id_number', document.getElementById('id_number').value);
            formData.append('profession_id', document.getElementById('profession').value);
            formData.append('gender', document.getElementById('male').checked ? 'M':'F');

        axios.post('/cms/user/users' ,formData
        )
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            document.getElementById('create_user').reset();
        })
        .catch(function (error) {
            console.log(error);
            showConfirm(error.response.data.message, false);
        });
        }

        function showConfirm(message, status){
            if(status){
                toastr.success(message);
            }else{
                toastr.error(message);
            }

        }
    </script>
@endsection
