@include('header')

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
                      
                      <th>Product</th>
                      <th>Qty</th>
                      <th>Price Per Unit</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td>Total:</td>
                            <td>&#x20A6;{{number_format($invoice->amount)}}</td>
                        </tr>
                    </tfoot>
                    <tbody>
                    @php
                        $count=1;
                    @endphp
                    @foreach($sales as $sale)
                    <tr>
                      <td>{{$count}}</td>
                      <td>{{$sale->stock->product->item}}</td>
                      <td>{{$sale->quantity}}</td>
                      <td>&#x20A6;{{number_format($sale->stock->product->selling_price,2)}}</td>                      
                      <td>&#x20A6;{{number_format($sale->amount,2)}}</td>
                    </tr>
                    @php
                        $count++;
                    @endphp
                    @endforeach

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
                  <a href="../invoice_print/{{$invoice->id}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
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
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
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
