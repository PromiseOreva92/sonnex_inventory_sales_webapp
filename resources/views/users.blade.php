@include('header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User</li>
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
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">New User</h3>
              </div>
              <!-- /.card-header -->
              @if(session()->has('message'))                                
                <div class="alert alert-success alert-dismissible mt-3">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-envelope"></i> Message!</h5>
                  {{ session()->get('message') }}
                </div>
              @endif
              <!-- form start -->
              <form method="post" action="{{route('new_user')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Fullname</label>
                    <input type="text" class="form-control" placeholder="Enter Fullname" name="fullname" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone</label>
                    <input type="text" class="form-control" placeholder="Enter Phone" name="phone" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Account Type</label>
                    <select name="user_type" class="form-control" required>
                      <option value="Super Admin">Super Admin</option>
                      <option value="Accountant">Accountant</option>
                      <option value="Manager">Manager</option>
                      <option value="Cashier">Cashier</option>
                      <option value="Invoice Raiser">Invoice Raiser</option>
                      <option value="Stock Keeper">Stock Keeper</option>
                      <option value="New Shop">New Shop</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Location</label>
                    <select name="location" id="" class="form-control" required>
                      @foreach($locations as $location)
                      <option value="{{$location->id}}">{{$location->place}}</option>
                      @endforeach
                    </select>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add New User</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


          </div>
          <!--/.col (left) -->

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User List</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Full Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Account Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp
                    @foreach($users as $user)


                      <div class="modal fade" id="modal-{{$user->id}}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h6 class="modal-title">Update User</h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>

                              <form method="post" action="update_user" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                      
                                      <input type="hidden" name="user_id" value="{{$user->id}}">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Fullname</label>
                                          <input type="text" class="form-control" name="fullname" value="{{$user->fullname}}" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Email</label>
                                          <input type="text" class="form-control" name="email" value="{{$user->email}}" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Phone</label>
                                          <input type="text" class="form-control" name="phone" value="{{$user->phone}}" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Priviledges/Roles</label>
                                          @if ($user->accountant == 0)
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="accountant" value="1">
                                              <label class="form-check-label">Accountant</label>
                                            </div>
                                          @else
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" checked=""  name="accountant" value="1">
                                              <label class="form-check-label">Accountant</label>
                                            </div>
                                          @endif

                                          @if ($user->stock_keeper == 0)
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="stock_keeper" value="1">
                                              <label class="form-check-label">Stock Keeper</label>
                                            </div>
                                          @else
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" checked="" name="stock_keeper" value="1">
                                              <label class="form-check-label">Stock Keeper</label>
                                            </div>
                                          @endif


                                          @if ($user->cashier == 0)
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="cashier" value="1">
                                              <label class="form-check-label">Cashier</label>
                                            </div>
                                          @else
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" checked="" name="cashier" value="1">
                                              <label class="form-check-label">Cashier</label>
                                            </div>
                                          @endif
                                          

                                          @if ($user->invoice_raiser == 0)
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="invoice_raiser" value="1">
                                              <label class="form-check-label">Invoice Raiser</label>
                                            </div>
                                          @else
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" checked="" name="invoice_raiser" value="1">
                                              <label class="form-check-label">Invoice Raiser</label>
                                            </div>
                                          @endif
                                          
                                      </div>
                                      
                                      
                                     
                                  </div>
                                  <!-- /.card-body -->

                                  <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Save changes</button>
                                  </div>
                              </form>
                          </div>
                        </div>
                      </div>
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$user->fullname}}</td>
                      <td>{{$user->phone}}</td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->user_type}}</td>
                      <td>
                        <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#modal-{{$user->id}}">
                            <i class="fa fa-user"></i> Edit Profile
                        </button>
                      </td>
                    </tr>
                    @php
                        $count++;
                    @endphp

                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; {{date('Y')}} <a href="">Sonnex</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
