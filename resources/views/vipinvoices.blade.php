@include('header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Record Entries (VIP)</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">VIP Invoice</li>
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
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">New Entry</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              @if(session()->has('message'))                                
                <div class="alert alert-success alert-dismissible mt-3">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-envelope"></i> Message!</h5>
                  {{ session()->get('message') }}
                </div>
              @endif
              <form method="post" action="{{route('new_vipinvoice')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Customer Name</label>
                        <select name="customer_id" class="form-control" required>
                        @foreach($customers as $customer)  
                                <option value="{{$customer->id}}">{{$customer->fullname}}</option>
                        @endforeach
                        </select>
                    </div>


                    <div id="inputs">
                        <div class="row item" id="">
                            <div class="col-6">
                                <label for="">Item</label>
                                <select name="items" id="" class="form-control item-name">
                                    @foreach($stocks as $stock)
                                        <option value="{{$stock->id}}">{{$stock->product->item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="">Qty</label>
                                <input type="number" class="form-control qty" placeholder="Quantity" min="1" value="1">
                            </div>
                            <div class="col-3">
                                <label for="">Discount per Unit (&#x20A6;)</label>
                                <input type="number" class="form-control discount" placeholder="Discount" min="0" value="0">
                            </div>
                           
                            
                            


                        </div>
                    </div>

                    

                    <div class="row mt-2 mb-3">
                        <div class="col-md-2 col-12">
                            <button type="button" class="btn btn-warning" onclick="additem()">
                                <span class="fa fa-plus"></span> Add Item
                            </button>
                        </div>

                        <div class="col-2">
                              <button class="btn btn-default" type="button" onclick="clearitems()">
                                <span class="fa fa-times"></span> Clear Items
                              </button>
                        </div>



                        <div class="col-md-12">
                            <button type="button" class="btn btn-danger mt-4" onclick="summarise()">
                                 Add Items to Summary
                            </button>
                        </div>
                    </div>

                    <script>
                        function clearitems() {
                          location.reload()
                        }
                        function additem(){
                            let con = document.getElementById('inputs')
                            var item = document.getElementsByClassName('item')[0].innerHTML;
                            var div = document.createElement("div");
                            div.setAttribute('class','row item')
                            div.innerHTML = item
                            insertAfter(div, con.lastElementChild)

                        }

                        function insertAfter(newNode, existingNode){
                            existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling)
                        }

                      


                        function summarise(){
                            let products = @json($products);
                            var stocks = @json($stocks);
                            console.log(products);
                            let textcontent = ""
                            let amount = 0
                            let cost = 0
                            let item_name = document.getElementsByClassName('item-name');
                            let qty = document.getElementsByClassName('qty');
                            let discnt = document.getElementsByClassName('discount');
                            for(let x=0; x < item_name.length; x++){

                               item = item_name[x].options[item_name[x].selectedIndex].text;
                              //  item_id = products[item_name[x].selectedIndex]['id'];
                              item_id = item_name[x].options[item_name[x].selectedIndex].value;
                               quantity = qty[x].value
                                discount = discnt[x].value
                               let product = products.find(o=>o.id == item_id)
                              //  item_amount = parseFloat(products[item_name[x].selectedIndex]['selling_price']) * quantity;
                              //  item_profit = item_amount - (parseFloat(products[item_name[x].selectedIndex]['cost_price']) * quantity)
                                item_amount = (parseFloat(product.selling_price) * quantity) - (parseFloat(discount) * quantity);
                                item_profit = item_amount - (parseFloat(product.cost_price) * quantity)
                               
                               if(x == item_name.length - 1){
                                textcontent += item_id + "-" + item + "-" + quantity + "-" + item_amount + "-" + item_profit + "-" + discount
                               }else{
                                textcontent += item_id + "-" + item + "-" + quantity + "-" + item_amount + "-" + item_profit + "-" + discount +";"

                               }
                               amount+= (parseFloat(product.selling_price) * quantity) - (parseFloat(discount) * quantity);
                               cost+= parseFloat(product.cost_price) * quantity;

                            }
                            profit = amount - cost;

                            document.getElementById('comment').value = textcontent;
                            document.getElementById('amount').value = amount
                            document.getElementById('profit').value = profit

                        }



                        // function fetch_product() {
                        //     const xhttp = new XMLHttpRequest();
                        //     xhttp.onload = function() {
                        //         document.getElementById("demo").innerHTML = this.responseText;
                        //     }
                        //     // xhttp.open("GET", "fetch_product/"+);
                        //     xhttp.send();
                        // }

                    </script>

                        <input type="text" name="comment" id="comment" class="form-control">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Amount to Pay</label>
                        <input type="number" name="expected_amount" id="amount" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                            <option value="Mobile Transfer">Mobile Transfer</option>
                            <option value="POS">POS</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Amount Paid</label>
                        <input type="number" name="amount" id="amount" class="form-control">
                    </div>

                    <input type="hidden" name="profit" id="profit" class="form-control">


                </div>


                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


          </div>
          <!--/.col (left) -->
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Invoice</h3>

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
                      <td>
                          @if($invoice->status == 0)
                              
                            Waiting <i class="fa fa-clock"></i>
                          @else

                          Approved <i class="fa fa-check"></i>
                          @endif
                      </td>
                      <td>
                      @if($invoice->status == 1)
                        <a href="invoice_view/{{$invoice->id}}" class="btn btn-outline-success" type="button">
                            Generate Invoice
                        </a>

                        @if($invoice->balance != 0)
                          <button href="" class="btn btn-outline-warning" type="button" data-toggle="modal" data-target="#modal-lg">
                              Generate Balance Invoice
                          </button>

                          <div class="modal fade" id="modal-lg">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Balance Payment</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form method="post" action="{{route('add_balance')}}" enctype="multipart/form-data">
                                      @csrf
                                      <div class="modal-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Payment Method</label>
                                            <select name="payment_method" class="form-control" required>
                                                <option value="Cash">Cash</option>
                                                <option value="Bank">Bank</option>
                                                <option value="Mobile Transfer">Mobile Transfer</option>
                                                <option value="POS">POS</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Amount</label>
                                          <input type="number" class="form-control" placeholder="Enter Amount" name="amount" required>
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Invoice No</label>
                                          <input type="number" class="form-control"  name="invoice_log" value="{{$invoice->log}}" readonly>
                                        </div>


                                          <input type="hidden" class="form-control"  name="invoice_id" value="{{$invoice->id}}" readonly>


                                      </div>

                                      <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="Submit" class="btn btn-primary">Submit</button>
                                      </div>
                          

                                  </form>
                                  
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                          </div>
                            <!-- /.modal -->
                        @endif

                      @endif
                      
                      </td>


                      <!-- /.modal -->
                    
                    
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
