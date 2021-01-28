@extends('cms.parent')
@section('title', 'Edit User Debits')

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
              <h3 class="card-title">Edit User Debits</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="edit_user_debits">
                @csrf
              <div class="card-body">

                <div class="form-group">
                    <label for="first_name">First Name :</label>
                    <input type="text" class="form-control" id="first_name" value="{{ $user_debt->first_name }}">
                </div>
                <div class="form-group">
                    <label for="last_name">last Name :</label>
                    <input type="text" class="form-control" id="last_name" value="{{ $user_debt->last_name }}">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile :</label>
                    <input type="number" class="form-control" id="mobile" value="{{ $user_debt->mobile }}">
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone :</label>
                    <input type="tel" class="form-control" id="telephone"  value="{{ $user_debt->telephone }}">
                </div>
                <div class="form-group">
                    <label for="address">Address :</label>
                    <input type="text" class="form-control" id="address"  value="{{ $user_debt->address }}">
                </div>
                <div class="col-sm-6">
                    <label>Gender :</label>
                    <div class="form-group">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="male" name="gender" @if($user_debt->gender == 'M') checked @endif>
                        <label for="male">Male
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="female" name="gender"  @if($user_debt->gender == 'F') checked @endif>
                        <label for="female">
                          Female
                        </label>
                      </div>
                    </div>
                  </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performSave({{ $user_debt->id }})" class="btn btn-primary">Save</button>
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
        function performSave(id){
            axios.put('/cms/user/debts-user/'+id, {
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
            location.href = '{{ route('debts-user.index') }}';
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
