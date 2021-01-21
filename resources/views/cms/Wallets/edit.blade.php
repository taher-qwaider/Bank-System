@extends('cms.parent')
@section('title', 'Edit Wallet')

@section('page-title', 'Wallet')
@section('home-page', 'Home')
@section('sub-page', 'Wallet')

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
              <h3 class="card-title">Edit Wallet</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create_wallet">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label>Currecny :</label>
                    <select class="form-control currencies" id="currecny" style="width: 100%;">
                        @foreach ($currencies as $currecny)
                            <option value="{{ $currecny->id }}" @if($wallet->currency->id == $currecny->id) selected @endif>{{ $currecny->name }}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="form-group">
                    <label for="wallet_name">Name :</label>
                    <input type="text" class="form-control" id="wallet_name" value="{{ $wallet->name }}">
                </div>
                <div class="form-group">
                    <label for="total">Total :</label>
                    <input type="number" class="form-control" id="total"  value="{{ $wallet->total }}">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="active" id="currency_active"
                            @if($wallet->active) checked @endif>
                        <label class="custom-control-label" for="currency_active">Active</label>
                    </div>
                </div>

              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performSave({{ $wallet->id }})" class="btn btn-primary">Save</button>
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
    </script>
    <script>
        function performSave(id){
            axios.put('/cms/admin/wallets/'+id, {
            name: document.getElementById('wallet_name').value,
            total: document.getElementById('total').value,
            currency_id: document.getElementById('currecny').value,
            active: document.getElementById('currency_active').checked,
        })
        .then(function (response) {
            console.log(response);
            // showConfirm(response.data.message, true);
            location.href = '{{ route('wallets.index') }}';
        })
        .catch(function (error) {
            console.log(error.response);
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
