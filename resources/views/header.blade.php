<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sonnex Industries</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">


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
          <p class="d-block">[{{Auth::user()->user_type}}]</p>
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

          @if(Auth::user()->user_type == "Super Admin"|| Auth::user()->user_type == "Manager" || Auth::user()->accountant == 1 )
          <li class="nav-item">
            <a href="{{route('users')}}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Accounts
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



          @endif

          <li class="nav-item">
            <a href="{{route('products')}}" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Products
              </p>
            </a>
          </li>
          @if(Auth::user()->invoice_raiser == 1 || Auth::user()->accountant == 1 || Auth::user()->user_type == "Manager" || Auth::user()->user_type == "Super Admin")
          <li class="nav-item">
            <a href="{{route('invoices')}}" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Invoice
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

          @endif

          @if(Auth::user()->cashier == 1 || Auth::user()->invoice_raiser == 1|| Auth::user()->user_type == "Super Admin"|| Auth::user()->user_type == "Manager" || Auth::user()->accountant == 1)
          <li class="nav-item">
            <a href="{{route('sales')}}" class="nav-link">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Sales
              </p>
            </a>
          </li>

          

          @endif


          @if(Auth::user()->stock_keeper == 1 || Auth::user()->accountant == 1 || Auth::user()->invoice_raiser == 1 || Auth::user()->user_type == "Manager" || Auth::user()->user_type == "Super Admin" || Auth::user()->super_admin == 1)
          <li class="nav-item">
            <a href="{{route('weighbill')}}" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                WeighBill
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
            <a href="{{route('stock_logs')}}" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Stock Log
              </p>
            </a>
          </li>

          
          <li class="nav-item">
            <a href="{{route('stock_in')}}" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Stock In Records
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('requisitions')}}" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Requisitions
              </p>
            </a>
          </li>

          @endif


          

          <li class="nav-item">
            <a href="{{route('cashbook')}}" class="nav-link">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Cashbook
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('expenses')}}" class="nav-link">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Expenses
              </p>
            </a>
          </li>


          @if(Auth::user()->user_type == "Manager")
          <li class="nav-item">
            <a href="{{route('vipcustomers')}}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                VIP
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('vipsales')}}" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                VIP Sales
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('vipinvoices')}}" class="nav-link">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                VIP Invoice
              </p>
            </a>
          </li>

          @endif

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