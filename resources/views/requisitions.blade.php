@include('header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Requisition List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Requisition</li>
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
          @if(Auth::user()->stock_keeper == 1 || Auth::user()->user_type == "Super Admin" || Auth::user()->user_type == "Manager")
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">New Requisition</h3>
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
              <form method="post" action="{{route('new_requisition')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Item Name</label>
                    <select name="product_id" id="product_id" class="form-control">
                      @foreach($products as $product)
                          <option value="{{$product->id}}">{{$product->item}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Quantity</label>
                    <input type="number" class="form-control" placeholder="Enter Quantity Supplied" name="quantity" required>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit New Requisition</button>
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
                <h3 class="card-title">Requisition List</h3>

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
                      <th>Item</th>
                      <th>Requested</th>
                      <th>Supplied</th>
                      <th>Location</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp

                    @foreach($requisitions as $requisition)
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$requisition->product->item}}</td>
                      <td>{{number_format($requisition->quantity_requested)}} Units</td>
                      <td>{{number_format($requisition->quantity_supplied)}} Units</td>
                      <td>{{Auth::user()->location->place}}</td>
                      <td>
                          @php

                              switch($requisition->status){
                                  case 0: 
                                    echo "Waiting";
                                    break;
                                  case 1:
                                    echo "Processing";
                                    break;
                                  case 2:
                                    echo "Completed";
                                    break;
                                  default:

                              }
                           
                          @endphp
                      </td>
                      <td>
                        @if($requisition->status == 0)
                          <a href="verify_requisition/{{$requisition->id}}" class="btn btn-sm btn-success">
                            Verify <span class="fa fa-pen"></span>
                          </a>
                        
                        @elseif($requisition->status == 1)
                        <a href="verify_requisition/{{$requisition->id}}" class="btn btn-sm btn-danger">
                          Accept <span class="fa fa-check"></span>
                        </a>
                        
                        @endif
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
