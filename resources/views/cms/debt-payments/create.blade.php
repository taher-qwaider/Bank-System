@extends('cms.parent')
@section('title', 'Create Debit Payment')

@section('page-title', 'Debt Payments')
@section('home-page', 'Home')
@section('sub-page', 'Payments')

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
              <h3 class="card-title">Create Debt Payments</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_debt_payment">
                @csrf
              <div class="card-body">

                <div class="form-group">
                    <label for="amount">Amount :</label>
                    <input type="number" class="form-control" id="amount" placeholder="Enter Amount">
                </div>
                <div class="form-group">
                    <label for="remain">Remain :</label>
                    <input type="number" class="form-control" id="remain" placeholder="Enter Remain">
                </div>
                <div class="form-group">
                    <label for="date">Date :</label>
                    <input type="date" class="form-control" id="date" placeholder="Enter Date">
                </div>
                <div class="form-group">
                    <label>Status :</label>
                    <select class="form-control payments" id="status" style="width: 100%;">
                        <option value="Paid">Paid</option>
                        <option value="Postponed">Postponed</option>
                        <option value="Waitting">Waitting</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="image">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="image">
                        <label class="custom-file-label" for="image">Choose Image</label>
                      </div>
                    </div>
                  </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performSave({{ $debt_id }})" class="btn btn-primary">Save</button>
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
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        function performSave(id){
            var formData=new FormData();
            formData.append('amount', document.getElementById('amount').value);
            formData.append('remain', document.getElementById('remain').value);
            formData.append('date', document.getElementById('date').value);
            formData.append('status', document.getElementById('status').value);
            formData.append('image', document.getElementById('image').files[0]);
            axios.post('/cms/user/debt/'+id +'/payments', formData)
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            // document.getElementById('create_debt_payment').reset();
            location.href ='{{ route('debt.payments.index', $debt_id) }}';
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
