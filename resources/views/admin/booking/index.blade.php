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
                                    <a href="{{ route('booking.create') }}" class="btn btn-primary btn-sm float-right">Book</a>
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
                                                <td id="none">@if($v->ride_status == 'Accepted')<span style="color:green">Rider On the Way</span>@elseif($v->ride_status=='I Reached')<span style="color:red">Rider Reached</span>@elseif($v->ride_status=='Trip Complete')<span style="color:Green">Trip Completed</span>@elseif($v->status=='Waiting') <span style="color:#5d561b;font-weight: bold">Waiting</span>@elseif($v->status=='Received Rider') <span style="color:green;font-weight: bold">Trip is Running</span> @else <span style="color:red;font-weight: bold">Canceled</span> @endif</td>
                                                <td id="none">
                                                    @if($v->status != 'Received Rider')
                                                        <a href="{{route('statusB', ['id'=>$v->id])}}" style="font-weight: bold">@if($v->status=='Waiting')<button class="btn-xs btn-primary btn-success"> Received Rider </button></a><a href="{{route('statusCancel', ['id'=>$v->id])}}" style="font-weight: bold"><button class="btn-xs btn-primary btn-danger"> Cancel </button></a>@endif
                                                    @else
                                                        <span class="btn-secondary">Disabled</span>
                                                    @endif
                                                        {{--
<a href="{{route('vehicle.edit',$v->id)}}"><i class="fa fa-lg fa-edit"></i></a>--}}
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


