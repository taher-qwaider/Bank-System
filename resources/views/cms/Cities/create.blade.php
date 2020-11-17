@extends('cms.parent')
@section('title')

@section('styles')

@section('page-title')
@section('home-page')
@section('sub-page')

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Quick Example</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('cities.store') }}">
                @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="active" id="customSwitch1">
                      <label class="custom-control-label" for="customSwitch1">Active</label>
                    </div>
                  </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
@section('scripts')

@endsection
