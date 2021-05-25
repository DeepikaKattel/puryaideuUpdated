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
                            <h1>Edit Vehicle Type</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Edit Vehicle Type Form</li>
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
                                    <h3 class="card-title">Edit Vehicle Type</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->

                                <form action="{{route('vehicleType.update',$vehicleType->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{old('name', $vehicleType->name)}}">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="price_km" placeholder="Price per kilometer" value="{{old('price_km', $vehicleType->price_km)}}">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="price_min" placeholder="Price per Min" value="{{old('price_min', $vehicleType->price_min)}}">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="base_fare" placeholder="Base Fare" value="{{old('base_fare', $vehicleType->base_fare)}}">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="commission" placeholder="Commission Percentage" value="{{old('commission', $vehicleType->commission)}}">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="capacity" placeholder="Capacity" value="{{old('capacity', $vehicleType->capacity)}}">
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

