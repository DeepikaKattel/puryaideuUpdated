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
                            <h1>Book</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Booking Form</li>
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
                                    <h3 class="card-title">Booking Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->

                                <form action="{{route('booking.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="from" class="control-label"><i class="far fa-dot-circle"></i> Origin</label>
                                            <input type="text" id="from" class="form-control" required placeholder="Origin">
                                        </div>
                                        <div class="form-group">
                                            <label for="to" class="control-label"><i class="fas fa-map-marker-alt"></i> Destination</label>
                                            <input type="text" id="to" class="form-control" required placeholder="Destination">
                                        </div>
                                        <button class="btn btn-primary" onclick="calcRoute();"><i class="fas fa-directions"></i> Show Distance</button>

                                        <div class="form-group">
                                            <input type="number" class="form-control" name="passenger_number" placeholder="Number of Passengers">
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
                                            <select class="form-control" name="user_id" required>
                                                <option value="" selected="" disabled>User</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}} with id {{$user->id}}</option>
                                                @endforeach
                                            </select>
                                            <span class="select-arrow"></span>
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passengerModal">
                                            Add Passenger Details
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="passengerModal" tabindex="-1" role="dialog" aria-labelledby="passengerModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="riderModalLabel">Add Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div id="googleMap">
                                        </div>

                                        <div id="output">
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


