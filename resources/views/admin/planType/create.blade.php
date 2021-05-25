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
            <h1>Add Plan Type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Plan Type Form</li>
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
                <h3 class="card-title">Plan Type</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form action="{{route('planType.store')}}" method="post" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Plan Type">
                     </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="percentage" placeholder="Percentage">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="criteria" placeholder="Criteria">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="remarks" placeholder="Remarks">
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

