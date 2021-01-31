@extends('cms.parent')
@section('title', 'Edit Debit Payment')

@section('page-title', 'Debt Payments')
@section('home-page', 'Home')
@section('sub-page', 'Payments')

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
              <h3 class="card-title">Edit Debt Payments</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="edit_debt_payment">
                @csrf
              <div class="card-body">

                <div class="form-group">
                    <label for="amount">Amount :</label>
                    <input type="number" class="form-control" id="amount" value="{{ $payment->amount }}">
                </div>
                <div class="form-group">
                    <label for="remain">Remain :</label>
                    <input type="number" class="form-control" id="remain" value="{{ $payment->remain }}">
                </div>
                <div class="form-group">
                    <label for="date">Date :</label>
                    <input type="date" class="form-control" id="date" value="{{ $payment->payment_date }}">
                </div>
                <div class="form-group">
                    <label>Status :</label>
                    <select class="form-control payments" id="status" style="width: 100%;">
                        <option value="Paid" @if($payment->status == 'Paid') selected @endif>Paid</option>
                        <option value="Postponed" @if($payment->status == 'Postponed') selected @endif>Postponed</option>
                        <option value="Waitting" @if($payment->status == 'Waitting') selected @endif>Waitting</option>
                    </select>
                  </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" onclick="performSave({{ $debt_id}},{{ $payment_id }})" class="btn btn-primary">Save</button>
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
        $('.payments').select2({
        theme: 'bootstrap4'
        });
    </script>
    <script>
        function performSave(debt_id, payment_id){
            axios.put('/cms/user/debt/'+debt_id +'/payments/'+payment_id, {
                amount:document.getElementById('amount').value,
                remain:document.getElementById('remain').value,
                date:document.getElementById('date').value,
                status:document.getElementById('status').value,
            })
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
