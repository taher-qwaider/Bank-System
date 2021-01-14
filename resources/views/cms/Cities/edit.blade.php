@extends('cms.parent')
@section('title', 'Edit City')

@section('page-title', 'City')
@section('home-page', 'Home')
@section('sub-page', 'City')

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Create city</h3>
            </div>
            @if ($errors->any())
            <div class="card-body">
                <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Validation Error!</h5>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </div>
            </div>
            @endif
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('cities.update', $city->id) }}">
                @csrf
                @method('PUT')
              <div class="card-body">
                <div class="form-group">
                  <label for="cityName">Name</label>
                  <input type="text" class="form-control" id="cityName" name="name" value="{{ $city->name }}" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="active" id="city-active" @if($city->active) checked @endif>
                      <label class="custom-control-label" for="city-active">Active</label>
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
