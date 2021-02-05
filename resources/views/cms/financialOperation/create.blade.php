@extends('cms.parent')
@section('title', 'Create Operation')

@section('page-title', 'Create Financial Operation')
@section('home-page', 'Home')
@section('sub-page', 'Operation')

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
              <h3 class="card-title">Create Operation</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_operation">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label>Frome:</label>
                    <select class="form-control sources" id="source" style="width: 100%;">
                        <option value="Wallets">Wallets</option>
                        <option value="Incomes">Incomes</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>To:</label>
                    <select class="form-control destinations" id="destination" style="width: 100%;">
                        <option value="Wallets">Wallets</option>
                        <option value="Income">Income</option>
                        <option value="Debt">Debt</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="amount">Amount :</label>
                    <input type="number" class="form-control" id="amount" placeholder="Enter Amount">
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
    <!-- Select2 -->
    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $('.destinations').select2({
        theme: 'bootstrap4'
        });
        $('.sources').select2({
        theme: 'bootstrap4'
        });
    </script>
    <script>
        function performSave(){
            axios.post('/cms/admin/financialOperation/' ,{
                destination_type:document.getElementById('destination'),
                source_type:document.getElementById('source'),
                amount: document.getElementById('amount')
            })
            .then(function (response) {
                console.log(response);
                showConfirm(response.data.message, true);
                document.getElementById('create_operation').reset();
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
