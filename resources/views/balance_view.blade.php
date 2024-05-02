<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Invoice</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->


      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <h5 class="brand-link">
      <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light ml-1" style="font-weight:bold !important">Sonnex Plastics</span>
    </h5>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <p class="d-block">{{Auth::user()->fullname}}</p>
        </div>
      </div>

      <!-- SidebarSearch Form -->


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('users')}}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Accounts
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('invoices')}}" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Invoice
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('stocks')}}" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Stock
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('customers')}}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('places')}}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Locations
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('settings')}}" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
              </p>
            </a>

          </li>
          <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                Logout
              </p>
            </a>

          </li>

          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12 text-center">
                  <h3>
                    Sonnex Surplus Industries Ltd.
                  </h3>
                  <p>Dealers On Home Care Plastic Products Gift Items and Take-aways</p>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Head Office:</strong><br>
                    B32 God's Favour Line Plastic Market<br>
                    Near Coca Cola,<br>
                    By/Asaba - Onitsha Expressway,<br>
                    Phone: 07035412695, 07088238454, 08182067371<br>
                  </address>
                </div>
                <!-- /.col -->

                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                  <address class="float-right">
                    <strong>Warehouse:</strong><br>
                    109 Obodoukwu Road<br>
                  </address>
                  
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                        
                    <tr>
                      <th>SN</th>
                      
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Price Per Unit</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td>Total:</td>
                            <td>&#x20A6;{{number_format($invoice->balance)}}</td>
                        </tr>
                    </tfoot>
                    <tbody>
                    @php
                        $count=1;
                    @endphp
                    <tr>
                      <td>{{$count}}</td>
                      <td>Balance Payment</td>
                      <td>-</td>
                      <td>-</td>                      
                      <td>&#x20A6;{{number_format($invoice->balance,2)}}</td>
                    </tr>

                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">

                <!-- /.col -->
                    <div class="col-md-6">


                            <p style="font-size:18px !important">
                            <b>Customer Name:</b> {{$invoice->customer->fullname}} <br>
                            <b>Phone:</b> {{$invoice->customer->phone}} <br>
                            <b>Address:</b> {{$invoice->customer->address}} <br>
                            <b>Invoice no:</b> #{{$invoice->log}}<br>
                            <br>
                            <b>Amount Paid:</b> &#x20A6;{{number_format($invoice->amount - $invoice->balance,2)}}<br>
                            <b>Balance:</b> &#x20A6;{{number_format($invoice->balance,2)}}<br>
                            <b>Payment Type:</b> {{$invoice->payment_type}} <br>
                            <b>Payment Date:</b> {{date('jS F Y',strtotime($invoice->created_at))}}<br>
                            <br>
                            </p>
                    </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="../balance_print/{{$invoice->id}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer no-print">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="">Sonnex</a>.</strong> All rights reserved.
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
