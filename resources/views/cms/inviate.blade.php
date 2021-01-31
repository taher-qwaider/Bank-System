@extends('cms.parent')
@section('title', 'Inviate a Friend')

@section('styles')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection
@section('page-title', 'Inviate')
@section('home-page', 'Home')
@section('sub-page', 'Inviate')

@section('content')
<section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Inviate a Friend</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <form id="inviate">
        <div class="card-body">
            <div class="form-group">
                <label for="email">User Email :</label>
                <input type="email" class="form-control" id="email"  placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label for="message">Message :</label>
                <input type="text" class="form-control" id="message"  placeholder="Enter Message">
            </div>
        </div>
      </form>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="button" onclick="inviate()" class="btn btn-primary">Inviate</button>
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
@endsection
@section('scripts')
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
  <script>
      function inviate(){
        axios.post('/cms/user/inviate',{
            email:document.getElementById('email').value,
            message:document.getElementById('message').value,
        })
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            document.getElementById('inviate').reset();
        })
        .catch(function (error) {
            console.log(error);
            showConfirm(error.response.data.message, false);
        });
      }

    function showConfirm(message, status){
        if(status){
            toastr.success(message);
        }else{
            toastr.error(message);
        }
    }

  </script>
@endsection
