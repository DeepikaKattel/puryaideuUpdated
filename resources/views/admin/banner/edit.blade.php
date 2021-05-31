@extends('admin.layouts.master')
@section('content')
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Add Advertisement</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Advertisement Form</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Advertisement</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->

                                <form action="{{route('banner.update',$banner->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="banner">Banner </label>
                                            <input type="file" name="banner" id="banner">
                                            <div class="col-md-2 col-sm-2">
                                                <img src="/storage/images/banners/{{$banner->banner}}" style=" height: auto; max-width:12em;" alt = "Image">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Advertisement Name" value="{{old('name',$banner->name)}}">
                                        </div>

                                        <div class="form-group">
                                            <label>Time Period:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                <input type="datetime-local" class="form-control float-right" name="time_period" id="reservationtime" value="{{old('time_period',$banner->time_period)}}">
                                            </div>
                                            <!-- /.input group -->
                                        </div>

                                    </div>

                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@endsection


