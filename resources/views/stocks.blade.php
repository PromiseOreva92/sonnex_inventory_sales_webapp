@include('header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Stock List</h1>
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
                <h3 class="card-title">New Stock</h3>
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
              <form method="post" action="{{route('new_stock')}}" enctype="multipart/form-data">
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
                    <label for="exampleInputEmail1">Location</label>
                    <select name="location" id="location" class="form-control">
                      @foreach($locations as $location)
                          <option value="{{$location->id}}">{{$location->place}}</option>
                      @endforeach
                    </select>
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
                  <button type="submit" class="btn btn-primary">Add New Stock</button>
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
                <h3 class="card-title">Stock List</h3>

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
                      <th>Qty Remaining</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp
                    @foreach($stocks as $stock)
                      
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$stock->product->item}}</td>
                      <td>{{$stock->quantity}}</td>
                      
                      <td>
                        <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#prev-modal-sm-{{$stock->product_id}}">
                            <i class="fa fa-clipboard"></i> Previous Ledger
                        </button>
                        <button class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modal-sm-{{$stock->product_id}}">
                            <i class="fa fa-clipboard"></i> Today's Ledger
                        </button>
                        <a href="ledger_card/{{$stock->product_id}}" class="btn btn-success btn-sm">
                          <i class="fa fa-eye"></i> View
                        </a>
                      </td>

                      <div class="modal fade" id="prev-modal-sm-{{$stock->product_id}}">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h6 class="modal-title">Update Previous Ledger for <br> ({{$stock->product->item}})</h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>

                              <form method="post" action="{{route('update_previous_ledger')}}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                      
                                      <input type="hidden" name="product_id" value="{{$stock->product_id}}">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Date</label>
                                          <input type="date" class="form-control" name="created_at" required>
                                      </div>
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Received (Stock In)</label>
                                          <input type="number" class="form-control" placeholder="Stock In" name="received" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Supplied (Stock Out)</label>
                                          <input type="number" class="form-control" placeholder="Stock Out" name="supplied" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Balance</label>
                                          <input type="number" class="form-control" placeholder="Balance" name="balance" required>
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

                      <div class="modal fade" id="modal-sm-{{$stock->product_id}}">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h6 class="modal-title">Update Today's Ledger for <br> ({{$stock->product->item}})</h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>


                              @php
                                  $arr = App\Http\Controllers\UserController::compute_ledger($stock->product_id);
                              @endphp

                              <form method="post" action="{{route('update_ledger')}}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                      
                                      <input type="hidden" name="product_id" value="{{$stock->product_id}}">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Received (Stock In)</label>
                                          <input type="number" class="form-control" placeholder="Stock In" name="received" value="{{$arr['received']}}" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Supplied (Stock Out)</label>
                                          <input type="number" class="form-control" placeholder="Stock Out" name="supplied" value="{{$arr['supplied']}}" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Balance</label>
                                          <input type="number" class="form-control" placeholder="Balance" name="balance" value="{{$arr['balance']}}" required>
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

                {{$stocks->links('pagination::bootstrap-4')}}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
          @if(Auth::user()->user_type == "Accountant" || Auth::user()->user_type == "Super Admin" || Auth::user()->user_type == "Manager")
          
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Main Shop Stock List</h3>

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
                      <th>Qty Remaining</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp
                    @foreach($stocks_m as $stock)
                      
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$stock->product->item}}</td>
                      <td>{{$stock->quantity}}</td>

                      <td>
                        <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#prev-modal-sm-m{{$stock->id}}">
                            <i class="fa fa-clipboard"></i> Previous Ledger
                        </button>
                        <button class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modal-sm-m{{$stock->id}}">
                            <i class="fa fa-clipboard"></i> Today's Ledger
                        </button>
                        <a href="ledger_card/{{$stock->product_id}}" class="btn btn-success btn-sm">
                          <i class="fa fa-eye"></i> View
                        </a>
                      </td>


                     <div class="modal fade" id="prev-modal-sm-m{{$stock->id}}">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h6 class="modal-title">Update Previous Ledger for <br> {{$stock->product->item}}</h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>


                              <form method="post" action="{{route('update_previous_ledger')}}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                      
                                      <input type="hidden" name="product_id" value="{{$stock->product_id}}">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Date</label>
                                          <input type="date" class="form-control" name="created_at" required>
                                      </div>
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Received (Stock In)</label>
                                          <input type="number" class="form-control" placeholder="Stock In" name="received" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Supplied (Stock Out)</label>
                                          <input type="number" class="form-control" placeholder="Stock Out" name="supplied" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Balance</label>
                                          <input type="number" class="form-control" placeholder="Balance" name="balance" required>
                                      </div>
                                  </div>

                                  <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Save changes</button>
                                  </div>
                              </form>
                          </div>
                        </div>
                      </div>
                      <div class="modal fade" id="modal-sm-m{{$stock->id}}">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h6 class="modal-title">Update Today's Ledger for <br> {{$stock->product->item}}</h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>


                              @php
                                  $arrm = App\Http\Controllers\UserController::compute_ledger2($stock->product_id,$stock->id,2);
                                  
                              @endphp

                              <form method="post" action="{{route('update_ledger')}}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                      
                                      <input type="hidden" name="product_id" value="{{$stock->product_id}}">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Received (Stock In)</label>
                                          <input type="number" class="form-control" placeholder="Stock In" name="received" value="{{$arrm['received']}}" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Supplied (Stock Out)</label>
                                          <input type="number" class="form-control" placeholder="Stock Out" name="supplied" value="{{$arrm['supplied']}}" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Balance</label>
                                          <input type="number" class="form-control" placeholder="Balance" name="balance" value="{{$arrm['balance']}}" required>
                                      </div>
                                  </div>

                                  <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Save changes</button>
                                  </div>
                              </form>
                          </div>
                        </div>
                      </div>
                      
                    </tr>
                    @php
                        $count++;
                    @endphp
                    @endforeach
                    
                  </tbody>
                </table>
                {{$stocks_m->links('pagination::bootstrap-4')}}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>


          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">New Shop Stock List</h3>

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
                      <th>Qty Remaining</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp
                    @foreach($stocks_n as $stock)
                      
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$stock->product->item}}</td>
                      <td>{{$stock->quantity}}</td>
                      
                      <td>
                          
                        <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#prev-modal-sm-n{{$stock->id}}">
                            <i class="fa fa-clipboard"></i> Previous Ledger
                        </button>
                        <button class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modal-sm-n{{$stock->id}}">
                            <i class="fa fa-clipboard"></i> Today's Ledger
                        </button>
                        <a href="ledger_card/{{$stock->product_id}}" class="btn btn-success btn-sm">
                          <i class="fa fa-eye"></i> View
                        </a>
                      </td>


                      <div class="modal fade" id="prev-modal-sm-n{{$stock->id}}">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h6 class="modal-title">Update Previous Ledger for <br> {{$stock->product->item}} </h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>

                              <form method="post" action="{{route('update_previous_ledger')}}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                      
                                      <input type="hidden" name="product_id" value="{{$stock->product_id}}">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Date</label>
                                          <input type="date" class="form-control" name="created_at" required>
                                      </div>
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Received (Stock In)</label>
                                          <input type="number" class="form-control" placeholder="Stock In" name="received" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Supplied (Stock Out)</label>
                                          <input type="number" class="form-control" placeholder="Stock Out" name="supplied" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Balance</label>
                                          <input type="number" class="form-control" placeholder="Balance" name="balance" required>
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
                      <div class="modal fade" id="modal-sm-n{{$stock->id}}">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h4 class="modal-title">Update Today's Ledger for <br> {{$stock->product->item}} </h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>


                              @php
                                  $arrn = App\Http\Controllers\UserController::compute_ledger2($stock->product_id,$stock->id,3);
                              @endphp

                              <form method="post" action="{{route('update_ledger')}}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                      
                                      <input type="hidden" name="product_id" value="{{$stock->product_id}}">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Received (Stock In)</label>
                                          <input type="number" class="form-control" placeholder="Stock In" name="received" value="{{$arrn['received']}}" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Supplied (Stock Out)</label>
                                          <input type="number" class="form-control" placeholder="Stock Out" name="supplied" value="{{$arrn['supplied']}}" required>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Balance</label>
                                          <input type="number" class="form-control" placeholder="Balance" name="balance" value="{{$arrn['balance']}}" required>
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
                {{$stocks_n->links('pagination::bootstrap-4')}}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
          @endif

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
