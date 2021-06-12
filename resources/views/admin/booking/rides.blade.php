@extends('admin.layouts.master')
@section('content')
    <div class="wrapper">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Bookings</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Bookings List</li>
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
                                    <h3 class="card-title">Table showing bookings</h3>

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
                                            <th>Booking By:</th>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Passengers(No.)</th>
                                            <th>Vehicle Type</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($booking as $v)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $v->user->name }}</td>
                                                <td>{{ $v->origin }}</td>
                                                <td>{{ $v->destination }}</td>
                                                <td>{{ $v->passenger_number }}</td>
                                                <td>{{ $v->vehicleType->name }}</td>
                                                <td id="none">@if($v->status == 'Received Rider')<span style="color:green">Trip is Running</span>@elseif($v->status=='Cancel') <span style="color:red;font-weight: bold">Cancelled By User</span> @elseif($v->ride_status=='Waiting') <span style="color:#24c5ff;font-weight: bold">Waiting</span> @elseif($v->ride_status=='Accepted') <span style="color:green;font-weight: bold">Accepted</span>@elseif($v->ride_status=='I Reached') <span style="color:green;font-weight: bold">Reached</span>@elseif($v->ride_status=='Trip Complete') <span style="color:green;font-weight: bold">Trip Completed</span>@else<span style="color:red;font-weight: bold">Cancelled</span> @endif</td>
                                                <td id="none">
                                                    @if($v->ride_status = 'Waiting')
                                                        <button type="button" class="btn-xs btn-primary btn-warning" data-toggle="modal" data-target="#riderModal" >
                                                            Accept
                                                        </button>
                                                    @elseif($v->ride_status = 'Accepted'){
                                                        <button class="btn-sm btn-primary btn-success"> Received Rider </button>
                                                     }
                                                        <span class="btn-secondary">Disabled</span>
                                                    @endif

                                                    @if($v->rider_id)
                                                        <a href="{{route('statusOfRider', ['id'=>$v->id])}}" style="font-weight: bold">@if($v->ride_status==1)<button class="btn-xs btn-primary btn-danger"> Cancel </button>@elseif($v->ride_status==0)<button class="btn-xs btn-primary btn-success"> Complete </button>@else<button style="display:none" class="btn-xs btn-primary btn-success"> Complete </button>@endif</a>
                                                    @endif
                                                    <div class="modal fade" id="riderModal" tabindex="-1" role="dialog" aria-labelledby="riderModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="riderModalLabel">Add Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('riderBook.update',$v->id)}}" method="post" enctype="multipart/form-data">
                                                                        @csrf

                                                                        <div class="form-group">
                                                                            <select class="form-control" name="rider_id" required>
                                                                                <option value="" selected="" disabled>Rider</option>
                                                                                @foreach($users as $user)
                                                                                    <option value="{{$user->id}}">{{$user->name}} with id {{$user->id}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="select-arrow"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <select class="form-control" name="vehicle_id" required>
                                                                                <option value="" selected="" disabled>Vehicle</option>
                                                                                @foreach($vehicles as $v)
                                                                                    <option value="{{$v->id}}">{{$v->vehicleType->name}} Model - {{$v->model}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="select-arrow"></span>
                                                                        </div>
{{--                                                                        <div class="form-group">--}}
{{--                                                                            <input type="vehicle" name="license" id="license" style="display: none"/>--}}
{{--                                                                            <label for="license" class="m-3">Click to upload License</label>--}}
{{--                                                                        </div>--}}
                                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                                    </form>
                                                                </div>
                                                                {{--                                    <div class="modal-footer">--}}
                                                                {{--                                        <a href="{{ route('admin.approve', $user->id) }}"--}}
                                                                {{--                                           class="btn btn-primary btn-sm">Approve</a>--}}

                                                                {{--                                    </div>--}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{--                                                    <a href="{{route('vehicle.edit',$v->id)}}"><i class="fa fa-lg fa-edit"></i></a>--}}
                                                    {{--                                                    @method('DELETE')--}}
                                                    {{--                                                    <a onclick="return confirm('Do you want to delete')" href="{{route('ve.destroy',$v->id)}}"><i class="fa fa-lg fa-minus-circle" style="color:red"></i></a>--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Booking By:</th>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Passengers(No.)</th>
                                            <th>Vehicle Type</th>
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


