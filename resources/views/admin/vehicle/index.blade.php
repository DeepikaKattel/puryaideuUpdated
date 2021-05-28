@extends('admin.layouts.master')
@section('content')
    <div class="wrapper">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Vehicles</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Vehicles List</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Table showing vehicles</h3>
                                    <a href="{{ route('vehicle.create') }}" class="btn btn-primary btn-sm float-right">Add Vehicle</a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @elseif(session('error'))
                                        <div class="alert alert-error" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Vehicle Type</th>
                                            <th>Rider</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Vehicle Year</th>
                                            <th>Vehicle Colour</th>
                                            <th>License Number</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($vehicle as $v)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $v->vehicleType->name }}</td>
                                                <td>{{ $v->rider->user->name }}</td>
                                                <td>{{ $v->brand }}</td>
                                                <td>{{ $v->model }}</td>
                                                <td>{{ $v->vehicle_year }}</td>
                                                <td>{{ $v->vehicle_colour }}</td>
                                                <td>{{ $v->license_number }}</td>
                                                <td id="none">@if($v->status==0) <span style="color:red;font-weight: bold">Inactive</span> @else <span style="color:green;font-weight: bold">Active</span> @endif</td>
                                                <td id="none">
                                                    <a href="{{route('statusV', ['id'=>$v->id])}}" style="font-weight: bold">@if($v->status==1)<button class="btn-sm btn-primary btn-danger"> Inactive </button>@else<button class="btn-sm btn-primary btn-success"> Active </button>@endif</a>
                                                    <a href="{{route('vehicle.edit',$v->id)}}"><i class="fa fa-lg fa-edit"></i></a>
                                                    @method('DELETE')
                                                    <a onclick="return confirm('Do you want to delete')" href="{{route('ve.destroy',$v->id)}}"><i class="fa fa-lg fa-minus-circle" style="color:red"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Vehicle Type</th>
                                            <th>Rider</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Vehicle Year</th>
                                            <th>Vehicle Colour</th>
                                            <th>License Number</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection


