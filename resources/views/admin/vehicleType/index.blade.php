@extends('admin.layouts.master')
@section('content')
<div class="wrapper">
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Vehicle Type</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Vehicle Types List</li>
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
                  <h3 class="card-title">Table showing vehicle types</h3>
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
                        <th>Price(1km)</th>
                        <th>Price(1 min)</th>
                        <th>Base Fare</th>
                        <th>Commission</th>
                        <th>Capacity</th>
                        <th>Status</th>

                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vehicleType as $vehicle)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->price_km }}</td>
                            <td>{{ $vehicle->price_min }}</td>
                            <td>{{ $vehicle->base_fare }}</td>
                            <td>{{ $vehicle->commission }}</td>
                            <td>{{ $vehicle->capacity }}</td>
                            <td id="none">@if($vehicle->status==0) <span style="color:red;font-weight: bold">Inactive</span> @else <span style="color:green;font-weight: bold">Active</span> @endif</td>
                           <td id="none">
                               <a href="{{route('statusVT', ['id'=>$vehicle->id])}}" style="font-weight: bold">@if($vehicle->status==1)<button class="btn-sm btn-primary btn-danger"> Inactive </button>@else<button class="btn-sm btn-primary btn-success"> Active </button>@endif</a>
                              <a href="{{route('vehicleType.edit',$vehicle->id)}}"><i class="fa fa-lg fa-edit"></i></a>
                              @method('DELETE')
                              <a onclick="return confirm('Do you want to delete')" href="{{route('v.destroy',$vehicle->id)}}"><i class="fa fa-lg fa-minus-circle" style="color:red"></i></a>
                           </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Vehicle Type</th>
                        <th>Price(1km)</th>
                        <th>Price(1 min)</th>
                        <th>Base Fare</th>
                        <th>Commission</th>
                        <th>Capacity</th>
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


