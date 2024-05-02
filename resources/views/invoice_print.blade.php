<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Invoice Print</title>

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}"> -->
  <style>
    .summary table{
      width:100%;
    }
    .summary td{
      border-bottom:1px solid #ccc;
    }
  </style>
</head>
<body style="font-size:18px !important;margin-left:5px !important;padding-left:5px !important;font-family:sans-serif;">
<div class="wrapper">
  <!-- Main content -->
  <section>
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h3 style="text-align:center">
            Sonnex Surplus Industries Limited.
            </h3>
            <p><small>Dealers On Home Care Plastic Products Gift Items and Take-aways</small></p>
        </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
        <div class="invoice-info" style="font-size:14px">
                <div class="">
                  <address>
                    <strong>Head Office:</strong><br>
                    B32 God's Favour Line Plastic Market<br>
                    Near Coca Cola,<br>
                    By/Asaba - Onitsha Expressway,<br>
                    Phone: 07035412695, 07088238454, 08182067371<br>
                  </address>
                </div>
                <!-- /.col -->

                <hr>
                <!-- /.col -->
                <div>
                  <address class="">
                    <strong>Warehouse:</strong><br>
                    109 Obodoukwu Road<br>
                  </address>
                  
                </div>
                <!-- /.col -->
        </div>
    <!-- /.row -->

    <hr>

    <!-- Table row -->
    <div class="row summary">
        <div class="">
            <table class="table" style="font-size:12px !important;font-weight:bold">
            <thead>
                
            <tr>                
                <th>Item</th>
                <th>Qty</th>
                <th>Price/Unit</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td>Total:</td>
                    <td>&#x20A6;{{number_format($invoice->amount)}}</td>
                </tr>
            </tfoot>
            <tbody>

            @foreach($sales as $sale)
            <tr>
                <td>{{$sale->stock->product->item}}</td>
                <td>{{number_format($sale->quantity)}}</td>
                <td>&#x20A6;{{number_format($sale->stock->product->selling_price,2)}}</td>                      
                <td>&#x20A6;{{number_format($sale->amount,2)}}</td>
            </tr>

            @endforeach

            </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">

        <div>
                <h5 style="text-align:center">Customer Details</h5>

                <p style="font-size:14px !important">
                <b>Name:</b> {{$invoice->customer->fullname}} <br>
                <b>Phone:</b> {{$invoice->customer->phone}} <br>
                <b>Address:</b> {{$invoice->customer->address}} <br>
                <b>Invoice no:</b> #{{$invoice->log}}<br>
                <br>

                </p>
                <h5 style="text-align:center">Payment Details</h5>
                <p style="font-size:14px !important">
                <b>Amount Paid:</b> &#x20A6;{{number_format($invoice->amount - $invoice->balance,2)}}<br>
                <b>Balance:</b> &#x20A6;{{number_format($invoice->balance,2)}}<br>
                <b>Payment Type:</b> {{$invoice->payment_type}} <br>
                <b>Payment Date:</b> {{date('jS F Y',strtotime($invoice->created_at))}}<br>
                <br>
                </p>
        </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
