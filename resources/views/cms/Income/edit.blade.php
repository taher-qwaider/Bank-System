@extends('cms.parent')
@section('title', 'Edit Income')

@section('page-title', 'Edit Income')
@section('home-page', 'Home')
@section('sub-page', 'Income')

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
              <h3 class="card-title">Edit Income</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="edit_income">
                @csrf
              <div class="card-body">
                <div class="form-group">
                <label for="total">Total :</label>
                <input type="number" class="form-control" id="total" value="{{ $income->total }}">
                </div>
                <div class="form-group">
                    <label>Currency:</label>
                    <select class="form-control currencies" id="currency" style="width: 100%;">
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" @if($income->currency_id == $currency->id) selected @endif>{{ $currency->name }}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="form-group">
                    <label for="date">Date :</label>
                    <input type="date" class="form-control" id="date" value="{{ $income->date }}">
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performSave({{ $income_type_id }})" class="btn btn-primary">Save</button>
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
        $('.currencies').select2({
        theme: 'bootstrap4'
        });
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        function performSave(income_type_id, income_id){
            // var formData=new FormData();
            // formData.append('income_type_id', id);
            // formData.append('total', document.getElementById('total').value);
            // formData.append('currency_id', document.getElementById('currency').value);
            // formData.append('image', document.getElementById('image').files[0]);
            // formData.append('date', document.getElementById('date').value);
            axios.put('/cms/admin/income_type/'+income_type_id+'/income/'+income_id ,{
                income_type_id:income_type_id,
                total:document.getElementById('total').value,
                currency_id:document.getElementById('currency').value,
                date:document.getElementById('date').value,
            }
            )
            .then(function (response) {
                console.log(response);
                showConfirm(response.data.message, true);
                document.getElementById('create_income').reset();
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
