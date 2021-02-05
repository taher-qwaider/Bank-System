@extends('cms.parent')
@section('title', 'Create Expense Type')

@section('page-title', 'Expense Type')
@section('home-page', 'Home')
@section('sub-page', 'Expense Type')

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
              <h3 class="card-title">Create Expense Type</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_expense_type">
                @csrf
              <div class="card-body">
                <div class="form-group">
                <label for="name">Name :</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label for="details">Details :</label>
                    <input type="text" class="form-control" id="details" placeholder="Enter Details">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="active"
                            checked>
                        <label class="custom-control-label" for="active">Active</label>
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

        axios.post('/cms/user/expense_type' ,{
            name:document.getElementById('name').value,
            details:document.getElementById('details').value,
            active:document.getElementById('active').checked,
        }
        )
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            document.getElementById('create_expense_type').reset();
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
