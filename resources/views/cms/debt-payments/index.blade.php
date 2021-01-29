@extends('cms.parent')
@section('title', 'Debts Payments')


@section('page-title', 'Debts Payments')
@section('home-page', 'home')
@section('sub-page', 'Debt')
@section('styles')
     <!-- Toastr -->
     <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Debts Payments</h3>

                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover table-bordered text-nowrap">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Remain</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Stings</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($debt_payments as $debt_payment)
                        <tr>
                            <td>{{ $debt_payment->id }}</td>
                            <td>{{ $debt_payment->amount }}</td>
                            <td>{{ $debt_payment->remain }}</td>
                            <td>{{ $debt_payment->payment_date }}</td>
                            <td><span class="badge bg-info" >{{ $debt_payment->status }}</span></td>
                            <td>
                                <div class="btn-group">
                                <a href="{{ route('debt.payments.edit', [$debt_id, $debt_payment->id]) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Edit
                                </a>&nbsp;
                                <a href="#" onclick="preformedDelete({{ $debt_id }}, {{ $debt_payment->id }}, this)" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                                </div>
                            </td>
                          @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="{{ route('debt.payments.create', $debt_id) }}" class="btn btn-success">Create Debt Payment</a>
                    {{-- {{ $debt_payments->links() }} --}}
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
@endsection

@section('scripts')
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        function preformedDelete(debt_id, payment_id, refernce){
            showAlert(debt_id, payment_id, refernce);
        }
        function showAlert(debt_id, payment_id, refernce){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(debt_id, payment_id, refernce);
                }
            })
        }
        function destroy(debt_id, payment_id, refernce){
            axios.delete('/cms/user/debt/'+debt_id+'/payments/'+payment_id)
            .then(function (response) {
                console.log(response.data);
                refernce.closest('tr').remove();
                responsAlert(response.data, true);
            })
            .catch(function (error) {
                console.log(error.response.data);
                responsAlert(error.response.data, false);
            })
        }
        function responsAlert(data, status){
            if(status){
                toastr.success(data.message);
            }else{
                toastr.error(data.message);
            }

        }
    </script>
@endsection
