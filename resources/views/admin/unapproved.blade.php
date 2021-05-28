@extends('admin.layouts.master')
@section('content')
<div class="wrapper">
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Unapproved Riders</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Unapproved Riders</li>
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
                  <h3 class="card-title">Table showing riders left to be approved</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>User name</th>
                      <th>Email</th>
                      <th>Registered at</th>
                      <th>Training Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($riders as $user)
                        <tr>
                            <td>{{ $user->user->name }}</td>
                            <td>{{ $user->user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>  <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#riderModal" data-id="{{ $user->id }}">
                                    Add Rider Details
                                </button></td>
                        </tr>
                        <!-- Modal -->
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
                                        <form action="{{route('admin.approve',$user->id)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Trained?</label>
                                                <select class="form-control" name="trained">
                                                    <option value="" selected="" disabled>--Select--</option>
                                                    <option value="YES">YES</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="file" name="license" id="license" style="display: none"/>
                                                <label for="license" class="m-3">Click to upload License</label>
                                            </div>
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

                    @empty
                        <tr>
                            <td colspan="4" style="padding-left:40%">No users yet to be approved.</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>User name</th>
                      <th>Email</th>
                      <th>Registered at</th>
                      <th>Training Details</th>
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


