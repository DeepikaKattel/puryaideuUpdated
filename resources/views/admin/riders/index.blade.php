@extends('admin.layouts.master')
@section('content')
    <div class="wrapper">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Riders</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Riders Lists</li>
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
                                    <h3 class="card-title">Table showing registered riders</h3>
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Vehicles</th>
                                            <th>Contact</th>
                                            <th>License</th>
                                            <th>Wallet</th>
                                            <th>Registered at</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($riders as $user)
                                            <tr>
                                                <td>{{ $user->user->name }}</td>
                                                <td>{{ $user->user->email }}</td>
                                                <td>
                                                    @foreach($user->vehicle as $vehicles)
                                                        {{$vehicles->vehicleType->name}} -
                                                        {{$vehicles->id}}
                                                    @endforeach
                                                </td>
                                                <td>{{ $user->user->contact1 }}</td>
                                                <td><a href="{{route('license.show',$user->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i>View</a></td>
                                                <td>{{ $user->wallet }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td id="none">@if($user->status==0) <span style="color:red;font-weight: bold">Inactive</span> @else <span style="color:green;font-weight: bold">Active</span> @endif</td>
                                                <td id="none">
                                                    <a href="{{route('statusR', ['id'=>$user->id])}}" style="font-weight: bold">@if($user->status==1)<button class="btn-sm btn-primary btn-danger"> Inactive </button>@else<button class="btn-sm btn-primary btn-success"> Active </button>@endif</a>
                                                    {{--                              <a href="{{route('users.edit',$user->id)}}"><i class="fa fa-lg fa-edit"></i></a>--}}
                                                    @method('DELETE')
                                                    <a onclick="return confirm('Do you want to delete')" href="{{route('ri.destroy',$user->id)}}"><i class="fa fa-lg fa-minus-circle" style="color:red"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Vehicles</th>
                                            <th>Contact</th>
                                            <th>License</th>
                                            <th>Registered at</th>
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


