@extends('cms.parent')
@section('title', 'Update Expense Type')

@section('page-title', 'Expense Type')
@section('home-page', 'Home')
@section('sub-page', 'Expense Type')

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
              <h3 class="card-title">Edit Expense Type</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_admin">
              <div class="card-body">
                <div class="form-group">
                <label for="name">Name :</label>
                <input type="text" class="form-control" id="name" value="{{ $expense_type->name }}">
                </div>
                <div class="form-group">
                    <label for="details">Details :</label>
                    <input type="text" class="form-control" id="details" value="{{ $expense_type->details }}">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="active" @if($expense_type->active) checked @endif>
                        <label class="custom-control-label" for="active">Active</label>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performupdata({{ $expense_type->id }})" class="btn btn-primary">Save</button>
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
        function performupdata(id){
            axios.put('/cms/user/expense_type/'+id , {
            name: document.getElementById('name').value,
            details: document.getElementById('details').value,
            active: document.getElementById('active').checked,
        })
        .then(function (response) {
            console.log(response);
            // showConfirm(response.data.message, true);
            window.location.href='{{ route('expense_type.index') }}';
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
