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
                            <h1>Book your ride</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Edit Plan Type Form</li>
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

                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="from" class="control-label"><i class="far fa-dot-circle"></i> Origin</label>
                                            <input type="text" id="from" class="form-control" required placeholder="Origin">
                                        </div>
                                        <div class="form-group">
                                            <label for="to" class="control-label"><i class="fas fa-map-marker-alt"></i> Destination</label>
                                            <input type="text" id="to" class="form-control" required placeholder="Destination">
                                        </div>

                                    </div>

                                </form>
                                <div class="card-footer">
                                    <button class="btn btn-primary" onclick="calcRoute();"><i class="fas fa-directions"></i> Submit</button>
                                </div>
                                <div id="googleMap">
                                </div>
                                <p id="demo"></p>
                                <div id="output">
                                </div>
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



