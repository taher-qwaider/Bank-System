@extends('cms.parent')
@section('title', 'Friendships')

@section('styles')
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection
@section('page-title', 'Friendships')
@section('home-page', 'Home')
@section('sub-page', 'Firend')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header border-0">
              <h3 class="card-title">Firendships</h3>
              <div class="card-tools">

              </div>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover table-striped table-valign-middle">
                <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Date</th>
                  <th>Message</th>
                  <th>Status</th>
                  <th>Setting</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($invitations as $inviate)
                        <tr>
                            <td>
                            <img src="{{ asset(Storage::url($inviate->sendUser->image)) }}" alt="user image" class="img-circle img-size-32 mr-2">
                            {{ $inviate->sendUser->full_name }}
                            </td>
                            <td>{{ $inviate->created_at }}</td>
                            <td>
                            {{ $inviate->message }}
                            </td>
                            <td>
                            {{ $inviate->status }}
                            </td>
                            <td>
                                @if($inviate->status == 'Waiting')
                                    <div class="btn-group">
                                        <button type="button" onclick="performUpdate('Accepted', {{ $inviate->id }})" class="btn btn-success">Accepted</button>
                                        <button type="button" onclick="performUpdate('Rejected', {{ $inviate->id }})" class="btn btn-danger">Rejected</button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
@endsection
@section('scripts')
<!-- Toastr -->
<script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        function performUpdate(status, id){
            axios.put('/cms/user/invitation/'+id, {
                status: status,
            })
            .then(function (response) {
                console.log(response);
                showConfirm(response.data.message, true);
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
