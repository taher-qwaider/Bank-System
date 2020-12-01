@extends('cms.parent')
@section('title', 'Profession')


@section('page-title', 'Profession')
@section('home-page', 'home')
@section('sub-page', 'Profession')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Professions</h3>

                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                @if (session()->has('updataMassege'))
                        <div class="card-body">
                            <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="far fa-check-circle"></i> {{ session('updataMassege') }}</h5>
                            </div>
                        </div>
                    @endif
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover table-bordered text-nowrap">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Active</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Settings</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($Professions as $Profession)
                        <tr>
                            <td>{{ $Profession->id }}</td>
                            <td>{{ $Profession->name }}</td>
                            <td>
                                @if($Profession->active)
                                    <span class="badge bg-success">{{ $Profession->stutus }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $Profession->stutus }}</span>
                                @endif
                            </td>
                            <td>{{ $Profession->created_at }}</td>
                            <td>{{ $Profession->updated_at }}</td>
                            <td>
                                <div class="btn-group">
                                <a href="{{ route('Profession.edit', $Profession->id) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" onclick="performDelete({{ $Profession->id }}, this)" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                                </div>
                            </td>
                            {{-- <span class="badge bg-danger">55%</span> --}}
                          @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $Professions->links() }}
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
    <script>
        function performDelete(id, referance){
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
                    destroy(id, referance);
                }
            })
        }
        function destroy(id, referance){
            axios.delete('/cms/admin/Profession/'+id)
            .then(function (response) {
                // handle success
                console.log(response.data);
                referance.closest('tr').remove();
                responsAlert(response.data);
            })
            .catch(function (error) {
                // handle error
                console.log(error.response.data);
                responsAlert(error.response.data);
            })
        }
        function responsAlert(data){
            let timerInterval
            Swal.fire({
            title: data.title,
            text: data.massege,
            icon: data.icon,
            timer: 2000,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                        b.textContent = Swal.getTimerLeft()
                    }
                }
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
            }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
            });
        }
    </script>
@endsection

