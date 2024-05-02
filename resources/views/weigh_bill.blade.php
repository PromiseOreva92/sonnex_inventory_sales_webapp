@include('header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Weigh Bill List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock</li>
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
          @if(Auth::user()->user_type == "Accountant" || Auth::user()->user_type == "Super Admin" || Auth::user()->user_type == "Manager")
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">New Weigh Bill</h3>
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
              <form method="post" action="{{route('new_weighbill')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Item Name</label>
                    <select name="item" id="item" class="form-control">
                      @foreach($products as $product)
                              @php
                                  $quantity = App\Http\Controllers\UserController::get_quantity($product->id);
                              @endphp
                          <option value="{{$product->id}}">{{$product->item}} - {{$quantity}} Unit(s) Left</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Customer Name</label>
                    <input type="text" class="form-control" name="customer" required>
                  </div>
            
                  <div class="form-group">
                    <label for="exampleInputEmail1">Quantity</label>
                    <input type="number" class="form-control" placeholder="Enter Quantity Supplied" name="quantity" min="1" required>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="date" class="form-control" placeholder="YYYY-MM-DD" name="recorded_at" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit Weigh Bill</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


          </div>
          @endif
          <!--/.col (left) -->

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Weigh bill List</h3>

                <div class="card-tools">
                  <form class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Customer</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp
                    @foreach($weighbills as $weighbill)
                      
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$weighbill->product->item}}</td>
                      <td>{{$weighbill->quantity}}</td>
                      <td>{{$weighbill->customer}}</td>
                      <td>{{date('jS F',strtotime($weighbill->recorded_at))}}</td>
                      
                      <td>
                        @if($weighbill->status == 0)
                        <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#modal-sm-{{$weighbill->id}}">
                            <i class="fa fa-clipboard"></i> Edit Weigh Bill
                        </button>
                        <a href="confirm_weighbill/{{$weighbill->id}}" class="btn btn-sm btn-warning">
                            <i class="fa fa-check"></i> Confirm Weigh Bill
                        </a>
                        <a href="delete_weighbill/{{$weighbill->id}}" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                        @else
                          <b>{{"Confirmed"}}</b>
                        @endif
                      </td>

                    

                      <div class="modal fade" id="modal-sm-{{$weighbill->id}}">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h6 class="modal-title">Update Weigh Bill</h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>


                              <form method="post" action="{{route('update_weighbill')}}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                      
                                      <input type="hidden" name="id" value="{{$weighbill->id}}">

                                      <input type="hidden" name="product_id" value="{{$weighbill->product_id}}">
                                      

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Customer Name</label>
                                        <input type="text" class="form-control" name="customer" value="{{$weighbill->customer}}" required>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Quantity</label>
                                        <input type="number" class="form-control" placeholder="Enter Quantity Supplied" name="quantity" min="1" value="{{$weighbill->quantity}}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date</label>
                                        <input type="date" class="form-control" placeholder="YYYY-MM-DD" name="recorded_at" value="{{$weighbill->recorded_at}}" required>
                                    </div>
                                  </div>
                                  <!-- /.card-body -->

                                  <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Save changes</button>
                                  </div>
                              </form>
                          </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
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
