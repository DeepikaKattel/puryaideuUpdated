@extends('admin.layouts.master')
@section('content')
    <div class="wrapper">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Advertisements</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Advertisement List</li>
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
                                    <h3 class="card-title">Table showing advertisements</h3>
                                    <a href="{{ route('banner.create') }}" class="btn btn-primary btn-sm float-right">Add Advertisement</a>
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
                                            <th>Banner</th>
                                            <th>Name</th>
                                            <th>Expire Date</th>
                                            <th>Added Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($banner as $b)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td><img src="/storage/images/banner/{{$b->banner}}" style=" max-height: 10em; max-width:10em;"></td>
                                                <td>{{ $b->name }}</td>
                                                <td>{{ $b->expire_date }}</td>
                                                <td>{{ $b->added_date }}</td>
                                                <td id="none">@if($b->status==0) <span style="color:red;font-weight: bold">Inactive</span> @else <span style="color:green;font-weight: bold">Active</span> @endif</td>
                                                <td id="none">
                                                    <a href="{{route('statusAd', ['id'=>$b->id])}}" style="font-weight: bold">@if($b->status==1)<button class="btn-sm btn-primary btn-danger"> Inactive </button>@else<button class="btn-sm btn-primary btn-success"> Active </button>@endif</a>
                                                    <a href="{{route('banner.edit',$b->id)}}"><i class="fa fa-lg fa-edit"></i></a>
                                                    @method('DELETE')
                                                    <a onclick="return confirm('Do you want to delete')" href="{{route('ba.destroy',$b->id)}}"><i class="fa fa-lg fa-minus-circle" style="color:red"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Banner</th>
                                            <th>Name</th>
                                            <th>Time Period</th>
                                            <th>Added Date</th>
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


