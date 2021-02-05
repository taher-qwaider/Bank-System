@extends('cms.parent')
@section('title', 'Incomes')


@section('page-title', $income_type->name . ' Incomes')
@section('home-page', 'home')
@section('sub-page', 'Incomes')
@section('styles')
     <!-- Toastr -->
     <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
{{-- {{ dd($incomes) }} --}}
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">{{ $income_type->name  }} Incomes</h3>

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
                        <th>Total</th>
                        <th>Date</th>
                        <th>Income Type Name</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Stings</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($income_type->incomes as $income)
                        <tr>
                            <td>{{ $income->id }}</td>
                            <td><span class="badge bg-info">{{ $income->total }}</span></td>
                            <td>{{ $income->date }}</td>
                            <td>{{ $income_type->name }}</td>
                            <td>{{ $income->created_at->format('Y-m-d') }}</td>
                            <td>{{ $income->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group">
                                <a href="{{ route('income_type.income.edit', [$income_type->id, $income->id]) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Edit
                                </a>&nbsp;
                                <a href="#" onclick="preformedDelete({{ $income_type->id }}, {{ $income->id }}, this)" class="btn btn-danger">
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
                    <a href="{{ route('income_type.income.create', $income_type->id) }}" class="btn btn-success">Create Income</a>
                        {{-- {{ $income_types->links() }} --}}
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
        function preformedDelete(income_type_id, income_id, refernce){
            showAlert(income_type_id, income_id, refernce);
        }
        function showAlert(income_type_id, income_id, refernce){
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
                    destroy(income_type_id, income_id, refernce);
                }
            })
        }
        function destroy(income_type_id, income_id, refernce){
            axios.delete('/cms/user/income_type/'+income_type_id + '/income/'+income_id)
            .then(function (response) {
                // handle success
                console.log(response.data);
                refernce.closest('tr').remove();
                responsAlert(response.data, true);
            })
            .catch(function (error) {
                // handle error
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
