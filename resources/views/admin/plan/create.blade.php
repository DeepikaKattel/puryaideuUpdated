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
            <h1>Add Plan </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Plan Form</li>
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
                <h3 class="card-title">Plan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form action="{{route('plan.store')}}" method="post" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="Title">
                     </div>
                    <div class="form-group">
                        <select class="form-control" name="validity" required>
                            <option value="" selected="" disabled>Select Validity Type</option>
                            <option value="custom">Custom</option>
                            <option value="custom">Permanent</option>
                        </select>
                        <span class="select-arrow"></span>
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="plan_type" required>
                            <option value="" selected="" disabled>Plan Type</option>
                            @foreach($planType as $plan)
                                <option value="{{$plan->id}}">{{$plan->name}}</option>
                            @endforeach
                        </select>
                        <span class="select-arrow"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" onfocus="(this.type='date')" placeholder="Activation Date" name="activation_date" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" onfocus="(this.type='date')" placeholder="Expiration Date" name="expire_date" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="usage_limit" placeholder="Usage Limit">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="used" placeholder="Used">
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

