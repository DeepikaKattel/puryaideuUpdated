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
                            <h1>Add Vehicle</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Add Vehicle Form</li>
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
                                    <h3 class="card-title">Vehicles</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->

                                <form action="{{route('vehicle.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="card-body">

                                        <div class="form-group">

                                            <select class="form-control" name="rider_id" required>
                                                <option value="" selected="" disabled>Rider</option>
                                                @foreach($riders as $rider)
                                                    <option value="{{$rider->id}}">{{$rider->user->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="select-arrow"></span>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control" name="vehicle_type" required>
                                                <option value="" selected="" disabled>Vehicle Type</option>
                                                @foreach($vehicleType as $vehicle)
                                                    <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="select-arrow"></span>
                                        </div>
                                        <div class="form-group">

                                            <input type="text" name="brand" class="form-control" required placeholder="Brand">
                                        </div>
                                        <div class="form-group">

                                            <input type="text" name="model" class="form-control" required placeholder="Model">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="vehicle_year" placeholder="Vehicle Year">
                                        </div>
                                        <div class="form-group">

                                            <input type="text" name="vehicle_colour" class="form-control" required placeholder="Vehicle Colour">
                                        </div>
                                        <div class="form-group">

                                            <input type="text" name="license_number" class="form-control" required placeholder="License Number">
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


