@include('header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-clock"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Last Login</span>
                <span class="info-box-number">
                 {{date('jS M, h:ia',strtotime(Auth::user()->last_login))}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-basket"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number">{{$products}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">{{$sales_no}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Customers</span>
                <span class="info-box-number">{{$customers}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
        @if(Auth::user()->user_type == "Super Admin" || Auth::user()->user_type == "Manager")
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>


                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-center">
                      <strong>Sales Report: This Year</strong>
                    </p>

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->

                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <h5 class="description-header">&#x20A6;{{number_format($totalrevenue)}}</h5>
                      <span class="description-text">TOTAL REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <h5 class="description-header">&#x20A6;{{number_format($totalprofit)}}</h5>
                      <span class="description-text">TOTAL PROFIT</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <h5 class="description-header">&#x20A6;{{number_format($totalcredit)}}</h5>
                      <span class="description-text">TOTAL CREDITS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->

                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <h5 class="description-header">&#x20A6;{{number_format($expenses)}}</h5>
                      <span class="description-text">TOTAL EXPENSES THIS MONTH</span>
                    </div>
                    <!-- /.description-block -->
                  </div>

                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>

          <!-- /.col -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Customer Revenue/ Profit Table</h3>

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
                      <th>Customer</th>
                      <th>Phone Number</th>
                      <th>Total Revenue</th>
                      <th>Total Profit</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp

                    @foreach($records as $record)
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$record->customer->fullname}}</td>
                      <td>{{$record->customer->phone}}</td>
                      <td>&#x20A6;{{number_format($record->total_revenue,2)}}</td>
                      <td>&#x20A6;{{number_format($record->total_profit,2)}}</td>
                    
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

            <div class="col-sm-6">
              <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Products in Stocks</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                      @foreach($stocks as $stock)
                        @php
                        if($stock->product_id == 0)
                          continue;
                        @endphp
                        
                      <li class="item">
                        <div class="product-img">
                          <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                        </div>
                        <div class="product-info">
                          <a class="product-title">{{$stock->product->item}}
                            <!-- <span class="badge badge-warning float-right">$1800</span> -->
                          </a>
                          
                            @php
                            $data_stock = $stock->quantity;
                            @endphp
                            @if($data_stock <=10 )
                            <span class="product-description text-danger" style="font-weight:bold">
                                {{$data_stock}} Unit(s) Left
                            </span>
                            @else
                            <span class="product-description text-success" style="font-weight:bold">
                                {{$data_stock}} Unit(s) Left
                            </span>
                            @endif
                          
                            
                        </div>
                      </li>

                      @endforeach

                      <!-- /.item -->
                    </ul>
                  </div>
                  <!-- /.card-body -->

                  <!-- /.card-footer -->
                </div>
            </div>
       @endif
       @if(Auth::user()->user_type == "Super Admin" || Auth::user()->user_type == "Manager" || Auth::user()->accountant == 1)
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Invoice Table</h3>

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
                      <th>Customer</th>
                      <th>Phone Number</th>
                      <th>Amount</th>
                      <th>Balance</th>
                      <th>Payment Method</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp

                    @foreach($invoices as $invoice)
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$invoice->customer->fullname}}</td>
                      <td>{{$invoice->customer->phone}}</td>
                      <td>&#x20A6;{{number_format($invoice->amount,2)}}</td>
                      <td>&#x20A6;{{number_format($invoice->balance,2)}}</td>
                      <td>{{$invoice->payment_type}}</td>
                      <td>
                          @if($invoice->status == 0)
                              
                            <span class="badge rounded-pill bg-warning p-2">Wating</span>
                          @else
                            <span class="badge rounded-pill bg-success p-2">Approved</span>
                          @endif
                      </td>

                      <td>

                        @if($invoice->status == 0)
                        <a href="approve/{{$invoice->id}}" class="btn btn-success btn-sm">
                          <i class="fa fa-check"></i>
                        </a>

                        @endif
                        <!-- <button type="button" class="btn btn-info btn-sm" title="View Payment" data-toggle="modal" data-target="#modal-lg">
                          <i class="fa fa-eye"></i>
                        </button> -->
                        <a href="invoice_view/{{$invoice->id}}" title="Generate Invoice" class="btn btn-danger btn-sm" type="button">
                            <i class="fa fa-print"></i>
                        </a>

                      </td>

                      <div class="modal fade" id="modal-lg">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Sonnex Plastics</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row">

                                  <!-- /.col -->
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
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
        @endif

        @if(Auth::user()->cashier == 1)
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Invoice Table for Cash</h3>

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
                      <th>Customer</th>
                      <th>Phone Number</th>
                      <th>Amount</th>
                      <th>Balance</th>
                      <th>Payment Method</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=1;
                    @endphp

                    @foreach($invoices as $invoice)

                      @if($invoice->payment_type == "Cash")

                        <tr>
                          <td>{{$count}}</td>
                          <td>{{$invoice->customer->fullname}}</td>
                          <td>{{$invoice->customer->phone}}</td>
                          <td>&#x20A6;{{number_format($invoice->amount,2)}}</td>
                          <td>&#x20A6;{{number_format($invoice->balance,2)}}</td>
                          <td>{{$invoice->payment_type}}</td>
                          <td>
                              @if($invoice->status == 0)
                                  
                                <span class="badge rounded-pill bg-warning p-2">Wating</span>
                              @else
                                <span class="badge rounded-pill bg-success p-2">Approved</span>
                              @endif
                          </td>

                          <td>

                            @if($invoice->status == 0)
                            <a href="approve/{{$invoice->id}}" class="btn btn-success btn-sm">
                              <i class="fa fa-check"></i>
                            </a>

                            @endif
                            <!-- <button type="button" class="btn btn-info btn-sm" title="View Payment" data-toggle="modal" data-target="#modal-lg">
                              <i class="fa fa-eye"></i>
                            </button> -->
                            <a href="invoice_view/{{$invoice->id}}" title="Generate Invoice" class="btn btn-danger btn-sm" type="button">
                                <i class="fa fa-print"></i>
                            </a>

                          </td>

                          <div class="modal fade" id="modal-lg">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Sonnex Plastics</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">

                                      <!-- /.col -->
                                  </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        
                        </tr>
                        @php
                            $count++;
                        @endphp
                      @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        @endif
        </div>

        
        <!-- /.row -->


      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
  <strong>Copyright &copy; {{date('Y')}} <a href="">Sonnex</a>.</strong> All rights reserved.
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script>
  var data = @json($data);
</script>
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
