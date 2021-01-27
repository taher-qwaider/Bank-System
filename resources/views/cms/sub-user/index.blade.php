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
                        <th>email</th>
                        <th>mobile</th>
                        <th>Profession</th>
                        <th>gender</th>
                        <th>Permissions</th>
                        <th>City</th>
                        <th>Is Deleted</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Stings</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($sub_users as $sub_user)
                        <tr>
                            <td>{{ $sub_user->id }}</td>
                            <td>{{ $sub_user->full_name }}</td>
                            <td>{{ $sub_user->email }}</td>
                            <td>{{ $sub_user->mobile }}</td>
                            <td>{{ $sub_user->profession->name }}</td>
                            <td><span class="badge bg-success">{{ $sub_user->gender_status }}</span></td>
                            <td>
                                <a href="{{ route('user.permission.index', $sub_user->id) }}" class="btn btn-info">{{ $sub_user->permissions_count }} / Permessions <i class="fas fa-user-tie"></i></a>
                            </td>
                            <td>{{ $sub_user->city->name }}</td>
                            <td>
                                <span @if($sub_user->trashed())  class="badge bg-danger"  @else  class="badge bg-success" @endif>{{ $sub_user->trashed() ? 'true': 'false' }}</span>
                            </td>
                            <td>{{ $sub_user->created_at }}</td>
                            <td>{{ $sub_user->updated_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('users.edit', $sub_user->id) }}" class="btn btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>&nbsp;
                                    @if ((Auth::user('user')->id != $user->id) && (!$sub_user->trashed()))
                                        <a href="#" onclick="preformedDelete({{ $user->id }})" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                    @endif
                                    @if ((Auth::user('user')->id != $user->id) && ($user->trashed()))
                                        <a href="#" onclick="restore({{ $user->id }})" class="btn btn-primary">
                                            <i class="fas fa-recycle"></i> Restore
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
                        {{ $sub_users->links() }}
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
        function preformedDelete(id){
            showAlert(id);
        }
        function showAlert(id){
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
                    destroy(id);
                }
            })
        }
        function restore(id){
            axios.delete('/cms/user/users/'+id+'/restore')
            .then(function (response) {
                console.log(response.data);
                responsAlert(response.data, true);
            })
            .catch(function (error) {
                console.log(error.response.data);
                responsAlert(error.response.data, false);
            })
        }
        function destroy(id){
            axios.delete('/cms/user/users/'+id)
            .then(function (response) {
                console.log(response.data);
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
