@extends('cms.parent')
@section('title', 'Create Debts')

@section('page-title', 'Debts')
@section('home-page', 'Home')
@section('sub-page', 'Debts')

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
              <h3 class="card-title">Create Debts</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_debits">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label>Debt User :</label>
                    <select class="form-control debt_users" id="debt_user" style="width: 100%;">
                        @foreach ($debt_users as $debt_user)
                            <option value="{{ $debt_user->id }}">{{ $debt_user->full_name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <a href="{{ route('debts-user.create') }}" class="btn btn-success">Create Debt User</a>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Currency:</label>
                    <select class="form-control currencies" id="currency" style="width: 100%;">
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="form-group">
                    <label for="total">Total :</label>
                    <input type="number" class="form-control" id="total"  placeholder="Enter Total">
                </div>
                <div class="form-group">
                    <label for="remain">Remain :</label>
                    <input type="number" class="form-control" id="remain"  placeholder="Enter Remain">
                </div>
                <div class="form-group">
                    <label>Debt Type :</label>
                    <select class="form-control debt_types" id="debt_type" style="width: 100%;">
                        <option value="Creditor">Creditor</option>
                        <option value="Debtor">Debtor</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Payment Type :</label>
                    <select class="form-control payments" id="payment_type" style="width: 100%;">
                        <option value="single">Single</option>
                        <option value="multi">Multi</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="description">Description :</label>
                    <input type="text" class="form-control" id="description"  placeholder="Enter Description">
                </div>
                <div class="form-group">
                    <label for="data">Data :</label>
                    <input type="date" class="form-control" id="data"  placeholder="Enter data">
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
        //Initialize Select2 Elements
        $('.currencies').select2({
        theme: 'bootstrap4'
        });
        $('.debt_types').select2({
        theme: 'bootstrap4'
        });
        $('.payments').select2({
        theme: 'bootstrap4'
        });
        $('.debt_users').select2({
        theme: 'bootstrap4'
        });
    </script>
    <script>
        function performSave(){
            axios.post('/cms/user/debts', {
            debt_user_id: document.getElementById('debt_user').value,
            currency_id: document.getElementById('currency').value,
            total: document.getElementById('total').value,
            remain: document.getElementById('remain').value,
            date: document.getElementById('data').value,
            debt_type: document.getElementById('debt_type').value,
            payment_type: document.getElementById('payment_type').value,
            description: document.getElementById('description').value,
        })
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            document.getElementById('create_debits').reset();
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
