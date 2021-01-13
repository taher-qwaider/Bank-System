@extends('cms.parent')
@section('title', 'Update Currency')

@section('page-title', 'Currency')
@section('home-page', 'Home')
@section('sub-page', 'Currency')

@section('styles')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Currency</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="create_currency">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="currency_name">Name</label>
                                    <input type="text" class="form-control" id="currency_name" value="{{ $currency->name }}" placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="active"  @if($currency->active) checked @endif>
                                        <label class="custom-control-label" for="active">Active</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" onclick="performSave({{ $currency->id }})" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        function performSave(id){
            axios.put('/cms/admin/currency/'+id, {
            name: document.getElementById('currency_name').value,
            active: document.getElementById('active').checked,
        })
        .then(function (response) {
            console.log(response);
            showConfirm(response.data.message, true);
            window.location.href='{{ route('currency.index') }}';
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
