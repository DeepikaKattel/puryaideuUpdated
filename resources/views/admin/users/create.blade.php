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
            <h1>Add Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Users Form</li>
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
                <h3 class="card-title">User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                     </div>

                      <div class="form-group">

                          <input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" required>
                          @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>


                  <div class="form-group row">

                      <div class="col-md-6">

                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                              @error('password')
                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                              @enderror
                      </div>

                      <div class="col-md-6">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                      </div>
                  </div>


                    <div class="form-group row">
                        <div class="col-md-6">
                            <select class="form-control" name="gender">
                                <option value="" selected="" disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>

                            </select>
                        </div>


                        <div class="col-md-6">
                            <input type="text" class="form-control @error('dob') is-invalid @enderror" onfocus="(this.type='date')" placeholder="Date of Birth" name="dob" value="{{ old('dob') }}" required autocomplete="dob">

                            @error('dob')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('contact1') is-invalid @enderror" placeholder="Contact Number" name="contact1" value="{{ old('contact1') }}" required autocomplete="contact1">

                            @error('contact')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('contact2') is-invalid @enderror" placeholder="Alternate Contact Number" name="contact2" value="{{ old('contact2') }}" required autocomplete="contact2">

                            @error('contact2')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-md-6">
                            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" placeholder="City" value="{{ old('city') }}" required autocomplete="city">

                            @error('city')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('area') is-invalid @enderror" name="area" placeholder="Area" value="{{ old('area') }}" required autocomplete="area">

                            @error('area')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>


                    </div>
                    <div class="form-group">

                        <select class="form-control" name="role" id="role">
                            <option value="" selected="" disabled>Select Role</option>
                            <option value="2">Rider</option>
                            <option value="3">Customer</option>
                        </select>

                        <div class="form-group row mt-3" id="rider">
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('license') is-invalid @enderror" placeholder="License Number" name="license_number" value="{{ old('license_number') }}" autocomplete="license_number">

                                @error('license')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control @error('experience') is-invalid @enderror" placeholder="Experience" name="experience" value="{{ old('experience') }}" autocomplete="experience">

                                @error('experience')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="file" name="license" id="license" style="display: none"/>
                                <label for="license" class="m-3">Click to upload License</label>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->       </div>
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

