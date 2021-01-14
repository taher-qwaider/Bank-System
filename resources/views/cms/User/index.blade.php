@extends('cms.parent')
@section('title', 'Users')


@section('page-title', 'Users')
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
                  <h3 class="card-title">Users</h3>

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
                        <th>email</th>
                        <th>mobile</th>
                        <th>Profession</th>
                        <th>gender</th>
                        <th>Permissions</th>
                        <th>City</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Stings</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->profession->name }}</td>
                            <td>{{ $user->gender_status }}</td>
                            <td>
                                <a href="" class="btn btn-info">{{ $user->permissions_count }} / Permessions <i class="fas fa-user-tie"></i></a>
                            </td>
                            <td>{{ $user->city->name }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>
                                <div class="btn-group">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Edit
                                </a>&nbsp;
                                @if (Auth::user('user')->id != $user->id)
                                    <a href="#" onclick="preformedDelete({{ $user->id }}, this)" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                @endif

                                </div>
                            </td>
                          @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                        {{ $users->links() }}
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
            axios.delete('/cms/user/users/'+id)
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
