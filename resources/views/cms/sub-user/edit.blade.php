@extends('cms.parent')
@section('title', 'Edit Sub User')

@section('page-title', 'Edit Sub User')
@section('home-page', 'Home')
@section('sub-page', 'Sub User')

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
              <h3 class="card-title">Edit Sub User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="edit_sub_user">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label>City :</label>
                    <select class="form-control cities" id="city" style="width: 100%;">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @if($city->id == $sub_user->city->id) selected @endif>{{ $city->name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Profession :</label>
                    <select class="form-control professions" id="profession" style="width: 100%;">
                        @foreach ($professions as $profession)
                            <option value="{{ $profession->id }}" @if($profession->id == $sub_user->profession->id) selected @endif>{{ $profession->name }}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="form-group">
                <label for="first_name">First Name :</label>
                <input type="text" class="form-control" id="first_name" value="{{ $sub_user->first_name }}" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name :</label>
                    <input type="text" class="form-control" id="last_name" value="{{ $sub_user->last_name }}" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" class="form-control" id="email" value="{{ $sub_user->email }}" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile :</label>
                    <input type="tel" class="form-control" id="mobile" value="{{ $sub_user->mobile }}"  placeholder="Enter mobile">
                </div>
                <div class="form-group">
                    <label for="id_number">ID Number :</label>
                    <input type="tel" class="form-control" id="id_number" value="{{ $sub_user->id_number }}"  placeholder="Enter ID">
                </div>
                <div class="form-group">
                    <label for="birth_date">Date Of Birth :</label>
                    <input type="tel" class="form-control" id="birth_date" value="{{ $sub_user->birth_date }}"  placeholder="Enter ID">
                </div>
                <div class="col-sm-6">
                    <!-- radio -->
                    <label>Gender :</label>
                    <div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="male" name="gender" @if ($sub_user->gender == 'M') checked @endif>
                        <label for="male">Male
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="female" name="gender" @if ($sub_user->gender == 'F') checked @endif>
                        <label for="female">
                          Female
                        </label>
                      </div>
                    </div>
                  </div>
              </div>

              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performupdata({{ $sub_user->id }})" class="btn btn-primary">Save</button>
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
        $('.professions').select2({
        theme: 'bootstrap4'
        });
    </script>
    <script>
        function performupdata(id){
            axios.put('/cms/user/sub-users/'+id, {
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            email: document.getElementById('email').value,
            id_number: document.getElementById('id_number').value,
            birth_date: document.getElementById('birth_date').value,
            mobile: document.getElementById('mobile').value,
            city_id: document.getElementById('city').value,
            profession_id: document.getElementById('profession').value,
            gender: document.getElementById('male').checked ? 'M':'F',
        })
        .then(function (response) {
            console.log(response);
            // showConfirm(response.data.message, true);
            window.location.href='{{ route('sub-users.index') }}';
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
