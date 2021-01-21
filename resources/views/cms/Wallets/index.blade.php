@extends('cms.parent')
@section('title', 'Walets')


@section('page-title', 'Walets')
@section('home-page', 'home')
@section('sub-page', 'Wallet')
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
                  <h3 class="card-title">Walets</h3>

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
                        <th>Name</th>
                        <th>Active</th>
                        <th>Total</th>
                        <th>Currency</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Stings</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($wallets as $wallet)
                        <tr>
                            <td>{{ $wallet->id }}</td>
                            <td>{{ $wallet->name }}</td>
                            <td><span @if($wallet->active) class="badge bg-success" @else class="badge bg-danger" @endif >{{ $wallet->status }}</span></td>
                            <td><span class="badge bg-info" >{{ $wallet->total }}</span></td>
                            <td><span class="badge bg-info" >{{ $wallet->currency->name }}</span></td>
                            <td>{{ $wallet->created_at->format('Y-m-d')  }}</td>
                            <td>{{ $wallet->updated_at->format('Y-m-d')  }}</td>
                            <td>
                                <div class="btn-group">
                                <a href="{{ route('wallets.edit', $wallet->id) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Edit
                                </a>&nbsp;
                                <a href="#" onclick="preformedDelete({{ $wallet->id }}, this)" class="btn btn-danger">
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
                        {{-- {{ $wallets->links() }} --}}
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
        function preformedDelete(id, refernce){
            showAlert(id, refernce);
        }
        function showAlert(id, refernce){
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
                    destroy(id, refernce);
                }
            })
        }
        function destroy(id, refernce){
            axios.delete('/cms/admin/wallets/'+id)
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
