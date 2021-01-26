@extends('cms.parent')
@section('title', 'Edit Debts')

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
              <h3 class="card-title">Edit Debts</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="edit_debts">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label>Debt User :</label>
                    <select class="form-control debt_users" id="debt_user_id" style="width: 100%;">
                        @foreach ($debt_users as $debt_user)
                            <option value="{{ $debt_user->id }}" @if($debt->user_debt->id == $debt_user->id) selected @endif>{{ $debt_user->full_name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <a href="{{ route('debts-user.edit', $debt->user_debt->id) }}" class="btn btn-success">Edit Debt User</a>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Currency:</label>
                    <select class="form-control currencies" id="currency" style="width: 100%;">
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" @if($debt->currency->id == $currency->id) selected @endif>{{ $currency->name }}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="form-group">
                    <label for="total">Total :</label>
                    <input type="number" class="form-control" id="total"  value="{{ $debt->total }}">
                </div>
                <div class="form-group">
                    <label for="remain">Remain :</label>
                    <input type="number" class="form-control" id="remain"  value="{{ $debt->remain }}">
                </div>
                <div class="form-group">
                    <label>Debt Type :</label>
                    <select class="form-control debt_types" id="debt_type" style="width: 100%;">
                        <option value="Creditor" @if($debt->debt_type == 'Creditor') selected @endif>Creditor</option>
                        <option value="Debtor" @if($debt->debt_type == 'Debtor') selected @endif>Debtor</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Payment Type :</label>
                    <select class="form-control payments" id="payment_type" style="width: 100%;">
                        <option value="single" @if($debt->payment_type == 'single') selected @endif>Single</option>
                        <option value="multi" @if($debt->payment_type == 'multi') selected @endif>Multi</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="description">Description :</label>
                    <input type="text" class="form-control" id="description"  value="{{ $debt->description }}">
                </div>
                <div class="form-group">
                    <label for="date">Date :</label>
                    <input type="date" class="form-control" id="date"  value="{{ $debt->date }}">
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
                <button type="button" onclick="performSave({{ $debt->id }})" class="btn btn-primary">Save</button>
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
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        function performSave(id){
            var formData=new FormData();
            formData.append('debt_user_id', document.getElementById('debt_user_id').value);
            formData.append('currency_id', document.getElementById('currency').value);
            formData.append('total', document.getElementById('total').value);
            formData.append('date', document.getElementById('date').value);
            formData.append('debt_type', document.getElementById('debt_type').value);
            formData.append('payment_type', document.getElementById('payment_type').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('remain', document.getElementById('remain').value);
            formData.append('image', document.getElementById('image').files[0]);
            console.log(document.getElementById('debt_user_id').value);
            axios.put('/cms/user/debts/'+id ,formData
            )
            .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            // document.getElementById('Edit_debits').reset();
            location.href = '{{ route('debts.index') }}';
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
