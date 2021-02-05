@extends('cms.parent')
@section('title', 'Update Income Type')

@section('page-title', 'Income Type')
@section('home-page', 'Home')
@section('sub-page', 'Income Type')

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
              <h3 class="card-title">Edit Income Type</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_admin">
              <div class="card-body">
                <div class="form-group">
                <label for="name">Name :</label>
                <input type="text" class="form-control" id="name" value="{{ $income_type->name }}">
                </div>
                <div class="form-group">
                    <label for="details">Last Name :</label>
                    <input type="text" class="form-control" id="details" value="{{ $income_type->details }}">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="active" @if($income_type->active) checked @endif>
                        <label class="custom-control-label" for="active">Active</label>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performupdata({{ $income_type->id }})" class="btn btn-primary">Save</button>
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
            axios.put('/cms/user/income_type/'+id , {
            name: document.getElementById('name').value,
            details: document.getElementById('details').value,
            active: document.getElementById('active').checked,
        })
        .then(function (response) {
            console.log(response);
            // showConfirm(response.data.message, true);
            window.location.href='{{ route('income_type.index') }}';
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
