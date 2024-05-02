@include('header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
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
          @if(Auth::user()->user_type == "Super Admin"|| Auth::user()->user_type == "Manager" )
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">New Item</h3>
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
              
              
              
              <form method="post" action="{{route('new_product')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Name</label>
                    <input type="text" class="form-control" placeholder="Enter Name of the Item" name="item" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Company Price</label>
                    <input type="number" class="form-control" placeholder="Enter Cost Price" name="cost_price" value="10" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Carriage Price</label>
                    <input type="number" class="form-control" placeholder="Enter Carriage Price" name="carriage_price" value="10" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Selling Price</label>
                    <input type="number" class="form-control" placeholder="Enter Selling Price" name="selling_price" value="20" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add New Product</button>
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
                <h3 class="card-title">Product List</h3>

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
                      <th>Product</th>
                      
                      @if(Auth::user()->user_type == "Super Admin"|| Auth::user()->user_type == "Manager" )
                      <th>Cost Price</th>
                      <th>Carriage Price</th>
                      @endif
                      
                      <th>Selling Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp
                    @foreach($products as $product)
                      @php 
                          if($product->id == 0)
                          continue;
                      @endphp
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$product->item}}</td>
                      
                      @if(Auth::user()->user_type == "Super Admin"|| Auth::user()->user_type == "Manager" )
                      
                      <td>&#x20A6;{{number_format($product->cost_price,2)}}</td>
                      <td>&#x20A6;{{number_format($product->carriage_price,2)}}</td>
                      @endif
                      
                      
                      <td>&#x20A6;{{number_format($product->selling_price,2)}}</td>


                    @if(Auth::user()->user_type == "Super Admin"|| Auth::user()->user_type == "Manager" )
                      <td>
                        <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#modal-sm-{{$product->id}}">
                            <i class="fa fa-pen"></i> Edit
                        </button>
                      </td>


                      <div class="modal fade" id="modal-sm-{{$product->id}}">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h4 class="modal-title">Update Price</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>

                              <form method="post" action="{{route('update_product')}}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                      
                                      <input type="hidden" name="product_id" value="{{$product->id}}">
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Company Price</label>
                                        <input type="number" class="form-control" placeholder="Enter Cost Price" name="cost_price" value="{{$product->cost_price}}" required>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Carriage Price</label>
                                        <input type="number" class="form-control" placeholder="Enter Carriage Price" name="carriage_price" value="{{$product->carriage_price}}" required>
                                      </div>

                                      

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Selling Price</label>
                                          <input type="number" class="form-control" placeholder="Enter Selling Price" name="selling_price" value="{{$product->selling_price}}" required>
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
                    
                    @endif
                    
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
