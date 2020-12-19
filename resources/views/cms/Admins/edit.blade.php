@extends('cms.parent')
@section('title', 'Create Admin')

@section('page-title', 'Admin')
@section('home-page', 'Home')
@section('sub-page', 'admin')

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
              <h3 class="card-title">Create Admin</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_admin">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label>City :</label>
                    <select class="form-control cities" id="city" style="width: 100%;">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @if($city->id == $admin->city_id) selected @endif>{{ $city->name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Profession :</label>
                    <select class="form-control profession" id="profession" style="width: 100%;">
                        @foreach ($professions as $profession)
                            <option value="{{ $profession->id }}" @if($profession->id == $admin->profession_id) selected @endif>{{ $profession->name }}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="form-group">
                <label for="fName">First Name :</label>
                <input type="text" class="form-control" id="fName" value="{{ $admin->first_name }}" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label for="lName">Last Name :</label>
                    <input type="text" class="form-control" id="lName" value="{{ $admin->last_name }}" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" class="form-control" id="email" value="{{ $admin->email }}" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile :</label>
                    <input type="tel" class="form-control" id="mobile" value="{{ $admin->mobile }}"  placeholder="Enter mobile">
                </div>
                <div class="col-sm-6">
                    <!-- radio -->
                    <label>Gender :</label>
                    <div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="male" name="gender" @if ($admin->gender == 'M') checked @endif>
                        <label for="male">Male
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="female" name="gender" @if ($admin->gender == 'F') checked @endif>
                        <label for="female">
                          Female
                        </label>
                      </div>
                    </div>
                  </div>
              </div>

              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performupdata({{ $admin->id }})" class="btn btn-primary">Save</button>
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
        $('.cities').select2({
        theme: 'bootstrap4'
        });
        $('.profession').select2({
        theme: 'bootstrap4'
        });
    </script>
    <script>
        function performupdata(id){
            axios.put('/cms/admin/admins/'+id, {
            first_name: document.getElementById('fName').value,
            last_name: document.getElementById('lName').value,
            email: document.getElementById('email').value,
            mobile: document.getElementById('mobile').value,
            city_id: document.getElementById('city').value,
            profession_id: document.getElementById('profession').value,
            gender: document.getElementById('male').checked ? 'M':'F',
        })
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            window.location.href='{{ route('admins.index') }}';
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
