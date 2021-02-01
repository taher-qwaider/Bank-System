@extends('cms.parent')
@section('title', 'Sub Users')


@section('page-title', 'Sub Users')
@section('home-page', 'home')
@section('sub-page', 'Users')
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
                  <h3 class="card-title">Sub Users</h3>

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
                        <th>Email</th>
                        <th>mobile</th>
                        <th>Id Number</th>
                        <th>gender</th>
                        <th>Date Of Birth</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Stings</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($sub_users as $sub_user)
                        <tr>
                            <td>{{ $sub_user->id }}</td>
                            <td>{{ $sub_user->subUser->full_name }}</td>
                            <td>{{ $sub_user->subUser->email }}</td>
                            <td>{{ $sub_user->subUser->mobile }}</td>
                            <td>{{ $sub_user->subUser->id_number }}</td>
                            <td><span class="badge bg-success">{{ $sub_user->subUser->gender_status }}</span></td>
                            <td>{{ $sub_user->subUser->birth_date }}</td>
                            <td>{{ $sub_user->subUser->created_at }}</td>
                            <td>{{ $sub_user->subUser->updated_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('sub-users.edit', $sub_user->id) }}" class="btn btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>&nbsp;
                                    <a href="#" onclick="preformedDelete({{ $sub_user->id }}, this)" class="btn btn-danger">
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
                        {{-- {{ $sub_users->links() }} --}}
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
        function preformedDelete(id, reference){
            showAlert(id, reference);
        }
        function showAlert(id, reference){
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
                    destroy(id, reference);
                }
            })
        }
        function destroy(id, reference){
            axios.delete('/cms/user/sub-users/'+id)
            .then(function (response) {
                console.log(response.data);
                reference.closest('tr').remove();
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
