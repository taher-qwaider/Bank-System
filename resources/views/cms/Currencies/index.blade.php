@extends('cms.parent')
@section('title', 'Currency')


@section('page-title', 'Currency')
@section('home-page', 'home')
@section('sub-page', 'Currency')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Currencies</h3>

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
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Stings</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($currencies as $currency)
                        <tr>
                            <td>{{ $currency->id }}</td>
                            <td>{{ $currency->name }}</td>
                            <td>
                                @if($currency->active)
                                    <span class="badge bg-success">{{ $currency->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $currency->status }}</span>
                                @endif
                            </td>
                            <td>{{ $currency->created_at->format('Y-m-d') }}</td>
                            <td>{{ $currency->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group">
                                    @can('Updata-Cities')
                                        <a href="{{ route('currency.edit', $currency->id) }}" class="btn btn-info">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @endcan
                                    &nbsp;
                                    @can('Delete-Cities')
                                        <a href="#" onclick="preformedDelete({{ $currency->id }}, this)" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                    @endcan
                                </div>
                            </td>
                            {{-- <span class="badge bg-danger">55%</span> --}}
                          @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                        {{ $currencies->links() }}
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
            axios.delete('/cms/admin/currency/'+id)
            .then(function (response) {
                // handle success
                console.log(response.data);
                refernce.closest('tr').remove();
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
