@extends('admin.layouts.master')
@section('content')
<div class="wrapper">
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Plan</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Plan List</li>
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
                  <h3 class="card-title">Table showing plans</h3>
                  <a href="{{ route('plan.create') }}" class="btn btn-primary btn-sm float-right">Add Plan</a>
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
                      <th>Title</th>
                        <th>Validity</th>
                        <th>Activation Date</th>
                        <th>Expiry Date</th>
                        <th>Usage Limit</th>
                        <th>Used</th>
                      <th>Plan Type</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($plan as $p)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $p->title}}</td>
                            <td>{{ $p->validity}}</td>
                            <td>{{ $p->activation_date}}</td>
                            <td>{{ $p->expire_date}}</td>
                            <td>{{ $p->usage_limit}}</td>
                            <td>{{ $p->used}}</td>
                            <td>{{ $p->plan_type }}</td>
                            <td id="none">@if($p->status==0) <span style="color:red;font-weight: bold">Inactive</span> @else <span style="color:green;font-weight: bold">Active</span> @endif</td>
                           <td id="none">
                               <a href="{{route('statusPl', ['id'=>$p->id])}}" style="font-weight: bold">@if($p->status==1)<button class="btn-xs btn-primary btn-danger"> Inactive </button>@else<button class="btn-xs btn-primary btn-success"> Active </button>@endif</a>
                              <a href="{{route('plan.edit',$p->id)}}"><i class="fa fa-lg fa-edit"></i></a>
                              @method('DELETE')
                              <a onclick="return confirm('Do you want to delete')" href="{{route('pl.destroy',$p->id)}}"><i class="fa fa-lg fa-minus-circle" style="color:red"></i></a>
                           </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Validity</th>
                        <th>Activation Date</th>
                        <th>Expiry Date</th>
                        <th>Usage Limit</th>
                        <th>Used</th>
                        <th>Plan Type</th>
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


