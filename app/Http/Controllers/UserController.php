<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Customer;
use App\Models\User;
use App\Models\Stock;
use App\Models\WeighBill;

use App\Models\Requisition;
use App\Models\Invoice;
use App\Models\Location;
use App\Models\Sale;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\Ledger;

use App\Models\Expense;
use App\Models\VipCustomer;

use App\Models\VipInvoice;
use App\Models\VipSale;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Carbon;

use App\Mail\SigninMail;
class UserController extends Controller
{
    public function login(){

        return view('login');
    }

    public function authuser(Request $request){
        
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            $usr = User::find($user->id);
            $usr->last_login = date('Y-m-d h:i:s');
            $usr->save();
            return redirect('dashboard');
        }
        else{
            $message = "Wrong Email or Password!";
            return back()->with('message',$message);
        }
    }

    public function newuser(){

        return view('register');
    }



    public function add_user(Request $request){
        $user = new User;
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->password = Hash::make($request->password);
        $user->location_id = $request->location;
        $user->save();
        return back()->with('message','user added');
    }

    public function update_user(Request $request){
        $user = User::find($request->user_id);
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if ($request->accountant) {
            $user->accountant = 1;

        } else {
            $user->accountant = 0;

        }

        if ($request->cashier) {
            $user->cashier = 1;

        } else {
            $user->cashier = 0;

        }

        if ($request->stock_keeper) {
            $user->stock_keeper = 1;

        } else {
            $user->stock_keeper = 0;

        }

        if ($request->invoice_raiser) {
            $user->invoice_raiser = 1;

        } else {
            $user->invoice_raiser = 0;

        }
        
        $user->save();
        return back()->with('message','user updated');
    }

    public function dashboard(){
        $customers = Customer::all()->count();
        $products = Product::all()->count();
        $sales_no = Sale::all()->count();
        $sales = Sale::all();
        $invoices = Invoice::orderBy('created_at','desc')->get();
        $totalrevenue = Invoice::where('status',1)
                                ->sum('amount');
        $totalprofit = Invoice::where('status',1)
                                ->sum('profit');
        $totalcredit = Invoice::where('status',1)
                                ->sum('balance');

            $Jan_revenue = Sale::whereYear('created_at', date('Y'))
                                ->whereMonth('created_at', '01')
                                ->sum('amount');
            $Feb_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '02')
                        ->sum('amount');
            $Mar_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '03')
                        ->sum('amount');
            
            $Apr_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '04')
                        ->sum('amount');  
            $May_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '05')
                        ->sum('amount');            
                        
            $Jun_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '06')
                        ->sum('amount');
            $Jul_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '07')
                        ->sum('amount');
            $Aug_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '08')
                        ->sum('amount');
            $Sep_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '09')
                        ->sum('amount');
            $Oct_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '10')
                        ->sum('amount');
            $Nov_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '11')
                        ->sum('amount');
            $Dec_revenue = Sale::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', '12')
                        ->sum('amount');
    
            $data = [
                'Jan'=>$Jan_revenue,
                'Feb'=>$Feb_revenue,
                'Mar'=>$Mar_revenue,
                'Apr'=>$Apr_revenue,
                'May'=>$May_revenue,
                'Jun'=>$Jun_revenue,
                'Jul'=>$Jul_revenue,
                'Aug'=>$Aug_revenue,
                'Sep'=>$Sep_revenue,
                'Oct'=>$Oct_revenue,
                'Nov'=>$Nov_revenue,
                'Dec'=>$Dec_revenue
    
            ];

            $sale_stocks = Sale::selectRaw('SUM(sales.quantity) as total_quantity, SUM(sales.amount) as total_amount, stock_id,stocks.id')
                 ->groupBy('stocks.id')
                 ->groupBy('stock_id')
                 ->orderBy('total_quantity','desc')
                 ->rightjoin('stocks','sales.stock_id','=','stocks.id')
                 ->get();
        $stocks = stock::all();
        $expenses = Expense::all()->sum('amount');

        $records = Sale::selectRaw('SUM(profit) as total_profit, SUM(amount) as total_revenue, customer_id')
                 ->groupBy('customer_id')
                 ->orderBy('total_profit','desc')
                 ->get();

        return view('dashboard',compact('customers','sales','products','invoices','totalrevenue',
        'totalprofit','totalcredit','data','sales_no','sale_stocks','stocks','expenses','records'));

        
    }


    public function users():View{
        $users = User::all();
        $locations = Location::all();
        return view('users',compact('users','locations'));
    }

    public function new_user(Request $request){
        $user = new User;
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->password = Hash::make($request->phone);
        $user->location_id = $request->location;
        $user->save();
        return back()->with('message','user added');
    }


    public function add_balance(Request $request) {
        $invoice = Invoice::find($request->invoice_id);
        $inlog = $invoice->log;
        $customer_id = $invoice->customer_id;
        $balance = $invoice->balance;
        $invoice->balance -= $request->amount;
        $invoice->save();


        $inv = new Invoice;
        $log = time();
        $inv->log  = $log;
        $inv->entry_by = Auth::user()->id;
        $inv->customer_id = $customer_id;
        $inv->payment_type = $request->payment_method;
        $inv->balance = $balance - $request->amount;
        $inv->amount = $request->amount;
        $inv->profit = 0;
        $inv->status = 0;
        $inv->comment = "Balance Payment-".$inlog;
        $inv->save();
        // if($inv->save()){
        //     $inv_id = Invoice::select('id')->where('log',$log)->first();
        //     $sale = new Sale;
        //     $sale->entry_by = Auth::user()->id;
        //     $sale->customer_id = $customer_id ;
        //     $sale->stock_id = 0;
        //     $sale->invoice_id = 0;
        //     $sale->quantity = 0;
        //     $sale->invoice_id = $inv_id->id;
        //     $sale->amount = $request->amount;
        //     $sale->profit = 0;
        //     $sale->save();
            

        // }
        return back();
    }
    public function invoices():View{
        $customers = Customer::orderBy('fullname','asc')
        ->get();
        $invoices = Invoice::orderBy('created_at','desc')
                   ->get();
        $products = Product::where('products.id','!=',0)->where('products.cost_price','>',10)
                    ->join('stocks','products.id','=','stocks.product_id')
                    ->select('products.item','products.cost_price','products.selling_price','stocks.product_id','stocks.id')
                    ->get();
        if (Auth::user()->user_type == "Super Admin") {
            $stocks = Stock::where('product_id','!=',0)->where('location_id','!=',1)->get();
        }else {
            $stocks = Stock::where('location_id',Auth::user()->location_id)->where('product_id','!=',0)->get();
        }
        
        return view('invoices',compact('customers','invoices','products','stocks'));
    }

    public function new_vipinvoice(Request $request){
        $invoice = new VipInvoice;
        $log = time();
        $invoice->log  = $log;
        $invoice->entry_by = Auth::user()->id;
        $invoice->location_id = Auth::user()->location_id;
        $invoice->customer_id = $request->customer_id;

        $invoice->payment_type = $request->payment_method;
        $invoice->balance = $request->expected_amount - $request->amount;
        $invoice->amount = $request->amount;
        $invoice->profit = $request->profit;
        $invoice->status = 1;
        $invoice->comment = $request->comment;
        $comment = $request->comment;

        $arr = explode(";",$comment);
        // print_r($arr);
        if($invoice->save()){
            $invoice_id = VipInvoice::select('id')->where('log',$log)->first();
            for ($i=0; $i < count($arr); $i++) { 
                $sale = new VipSale;
                $sale->entry_by = Auth::user()->id;
                $sale->location_id = Auth::user()->location_id;
                $sale->customer_id = $request->customer_id;
                $items = $arr[$i];
                $comment_arr = explode('-',$items);
                $sale->stock_id = $comment_arr[0];
                $sale->quantity = $comment_arr[2];

                
                $sale->amount = $comment_arr[3];
                $sale->profit = $comment_arr[4];
                $sale->discount = $comment_arr[5];
                $sale->invoice_id = $invoice_id->id;
                $sale->status = 1;

                $sale->save();
            }
    
            return back()->with('message','Invoice has been Saved');
        }else{
            return back()->with('message','Error'); 
        }



    }
    public function vipinvoices():View{
        $customers = VipCustomer::orderBy('fullname','asc')
        ->get();
        $invoices = VipInvoice::orderBy('created_at','desc')
                   ->get();
        $products = Product::where('products.id','!=',0)->where('products.cost_price','>',10)
                    ->join('stocks','products.id','=','stocks.product_id')
                    ->select('products.item','products.cost_price','products.selling_price','stocks.product_id','stocks.id')
                    ->get();
        if (Auth::user()->user_type == "Super Admin") {
            $stocks = Stock::where('product_id','!=',0)->where('location_id','!=',1)->get();
        }else {
            $stocks = Stock::where('location_id',Auth::user()->location_id)->where('product_id','!=',0)->get();
        }
        
        return view('vipinvoices',compact('customers','invoices','products','stocks'));
    }

    public function new_invoice(Request $request){
        $invoice = new Invoice;
        if($request->amount > $request->expected_amount){
            return back()->with('message','Error: The Amount You entered is more than Calculated Amount'); 
        }
        $log = time();
        $invoice->log  = $log;
        $invoice->entry_by = Auth::user()->id;
        $invoice->location_id = Auth::user()->location_id;
        $invoice->customer_id = $request->customer_id;

        $invoice->payment_type = $request->payment_method;
        $invoice->balance = $request->expected_amount - $request->amount;
        $invoice->amount = $request->amount;
        $invoice->profit = $request->profit;
        $invoice->status = 0;
        $invoice->comment = $request->comment;
        $comment = $request->comment;

        $arr = explode(";",$comment);
        // print_r($arr);
        if($invoice->save()){
            $invoice_id = Invoice::select('id')->where('log',$log)->first();
            for ($i=0; $i < count($arr); $i++) { 
                $sale = new Sale;
                $sale->entry_by = Auth::user()->id;
                $sale->location_id = Auth::user()->location_id;
                $sale->customer_id = $request->customer_id;
                $items = $arr[$i];
                $comment_arr = explode('-',$items);
                $sale->stock_id = $comment_arr[0];
                $sale->quantity = $comment_arr[2];

                
                $sale->amount = $comment_arr[3];
                $sale->profit = $comment_arr[4];
                $sale->discount = $comment_arr[5];
                $sale->invoice_id = $invoice_id->id;

                // $stock = Stock::find($comment_arr[0]);
                // $stock->quantity -= $comment_arr[2];
                // $stock->save();

                $sale->save();
            }
    
            return back()->with('message','Invoice has been Saved');
        }else{
            return back()->with('message','Error'); 
        }



    }
    public function invoice_view($id){
        $invoice = Invoice::find($id);
        $sales = Sale::where('invoice_id',$id)->get();
        return view('invoice_view',compact('invoice','sales'));
    }

    public function invoice_print($id){
        $invoice = Invoice::find($id);
        $sales = Sale::where('invoice_id',$id)->get();
        return view('invoice_print',compact('invoice','sales'));
    }
    public function balance_view($id){
        $invoice = Invoice::find($id);
        // $sales = Sale::where('invoice_id',$id)->get();
        return view('balance_view',compact('invoice'));
    }

    public function balance_print($id){
        $invoice = Invoice::find($id);
        $sales = Sale::where('invoice_id',$id)->get();
        return view('balance_print',compact('invoice','sales'));
    }

    public function approve($id){
        $invoice = Invoice::find($id); 
        $invoice->status = 1;
        $invoice->save();

        Sale::where('invoice_id',$id)
            ->join('stocks','sales.stock_id','=','stocks.id')
            ->select('sales.*')
            ->selectRaw('stocks.quantity as stock_quantity, (stocks.quantity - sales.quantity) as qty')
            ->lazy()->each(function (object $sales) {
                Sale::where('invoice_id',$sales->invoice_id)
                        ->update([
                            'sales.status'=>1,
                        ]);
                Stock::where('stocks.id',$sales->stock_id)
                        ->update(['stocks.quantity'=>$sales->qty]);
            });

        return back();
    }
    public function stocks():View{
        
        
        $products = Product::where('id','!=',0)->where('products.cost_price','>',10)->orderBy('item','ASC')
                    ->get();
        $locations= Location::all();
        $stocks = Stock::where('location_id',Auth::user()->location_id)->paginate(10);
        $stocks_m =Stock::where('location_id',2)->paginate(10);
        $stocks_n = Stock::where('location_id',3)->paginate(10);
        return view('stocks',compact('products','locations','stocks','stocks_m','stocks_n'));

    }

    public function stock_view($id):View{
        $stocks= Stock::where('product_id',$id)->get();
        $product = Product::where('id',$id)->first();
        return view('stock_view',compact('stocks','product'));
    }
    public function stock_logs():View{
        $stocks = StockLog::orderBy('created_at','DESC')->get();
        return view('stock_logs',compact('stocks'));
    }

    public static function get_quantity($id){
        if ($stock = Stock::where('product_id',$id)->where('location_id',1)->exists()) {
            $stock = Stock::where('product_id',$id)->where('location_id',1)->first();
            return $stock->quantity;
        }else {
            return 0;
        }
        

    }

    public static function get_quantity2($id){

        if ($stock = Stock::where('id',$id)->where('location_id',Auth::user()->location_id)->exists()) {
            $stock = Stock::where('id',$id)->where('location_id',Auth::user()->location_id)->first();
            return $stock->quantity;
        }else {
            return 0;
        }
        

    }

    public function weighbill():View{


        
        
        $products = Product::where('id','!=',0)->where('products.cost_price','>',10)->orderBy('item','ASC')
                    ->get();
        $weighbills = weighbill::all();
        return view('weigh_bill',compact('products','weighbills'));

    }

    public function new_weighbill(Request $request) {

        $stockw = Stock::where('product_id',$request->item)
                            ->where('location_id',1)
                            ->first();

        if ($request->quantity > $stockw->quantity) {
            return back()->with('message','The Quantity you applied for is not available');  
        }else {


            
            $weighbill = new Weighbill;
            $weighbill->product_id = $request->item;
            $weighbill->quantity = $request->quantity;
            $weighbill->customer = $request->customer;
            $weighbill->user_id = Auth::user()->id;
            $weighbill->location_id = 1;
            $weighbill->recorded_at = date("Y-m-d H:i:s",strtotime($request->recorded_at));

            

            
            if($weighbill->save()){
            
            
            return back()->with('message','New Weigh Bill has been Added');
            }else{
                return back()->with('message','Error'); 
            }
        }

    }

    public function update_weighbill(Request $request) {

        $stockw = Stock::where('product_id',$request->product_id)
                            ->where('location_id',1)
                            ->first();

        if ($request->quantity > $stockw->quantity) {
            return back()->with('message','The Quantity you applied for is not available');  
        }else {


            
            $weighbill = Weighbill::find($request->id);
            $weighbill->product_id = $request->product_id;
            $weighbill->quantity = $request->quantity;
            $weighbill->customer = $request->customer;
            $weighbill->user_id = Auth::user()->id;
            $weighbill->location_id = 1;
            $weighbill->recorded_at = date("Y-m-d H:i:s",strtotime($request->recorded_at));

            

            
            if($weighbill->save()){
            
            
            return back()->with('message','Weigh Bill has been Updated');
            }else{
                return back()->with('message','Error'); 
            }
        }

    }

    public function delete_weighbill($id){
        $weighbill = WeighBill::find($id);
        $weighbill->delete();
        return back();
    }

    public function confirm_weighbill($id){
        $weighbill = WeighBill::find($id);
        $weighbill->status = 1;
        if(!Stock::where('product_id',$weighbill->product_id)->where('location_id',1)->exists()){
                return back()->with('message','The items you are trying to confirm is available on Stocks');    
        }
        $stock = Stock::where('product_id',$weighbill->product_id)
                                            ->where('location_id',1)
                                            ->first();
        
        $stock->quantity -= $weighbill->quantity;
        
        
        $product = Product::find($weighbill->product_id);
        $stock_log = new StockLog;  
        $stock_log->quantity = $weighbill->quantity;
        $stock_log->caps = (($product->cost_price + $product->carriage_price) * $weighbill->quantity);
        $stock_log->expected_profit = ($product->selling_price * $weighbill->quantity) - (($product->cost_price + $product->carriage_price) * $weighbill->quantity);
        $stock_log->location_id = 1;
        $stock_log->entry_by = Auth::user()->id;
        $stock_log->type = "New WeighBill";
        $stock_log->product_id = $weighbill->product_id;
        $stock_log->status = 1;
        $stock_log->recorded_at = date("Y-m-d H:i:s",strtotime($weighbill->recorded_at));

        

        if($weighbill->save()){  
            $stock_log->save();
            $stock->save();  
            return back()->with('message','New Weigh Bill has been Added');
        }else{
                return back()->with('message','Error'); 
        }

    }
    

    public function new_stock(Request $request){

        //if product exists in warehouse

        if (Stock::where('product_id',$request->item)->where('location_id',1)->exists()) {            
                    // if the product exists in location then its an update
                    if(Stock::where('product_id',$request->item)->where('location_id',$request->location)->exists()){

                                // if location is not warehouse check if the quantity applied for is available
                            if ($request->location != 1) {
                                $stockw = Stock::where('product_id',$request->item)
                                ->where('location_id',1)
                                ->first();
                                if ($request->quantity > $stockw->quantity) {
                                    return back()->with('message','Quantity you applied for is not available');  
                                }else{
                                    // if quantity is available

                                    // $stock = Stock::where('product_id',$request->item)
                                    //         ->where('location_id',$request->location)
                                    //         ->first();
                                
                                    // $stock->quantity += $request->quantity;//adj
                                    // $stockw->quantity-= $request->quantity;
                                    // $stockw->save();
                                    $product = Product::find($request->item);
                                    $stock_log = new StockLog;  
                                    $stock_log->quantity = $request->quantity;
                                    $stock_log->caps = (($product->cost_price + $product->carriage_price) * $request->quantity);
                                    $stock_log->expected_profit = ($product->selling_price * $request->quantity) - (($product->cost_price + $product->carriage_price) * $request->quantity);
                                    $stock_log->location_id = $request->location;
                                    $stock_log->product_id = $request->item;
                                    $stock_log->entry_by = Auth::user()->id;
                                    $stock_log->type = "Update";
                                    $stock_log->recorded_at = date("Y-m-d H:i:s",strtotime($request->recorded_at));
                                    $stock_log->save();

                                    if($stock_log->save()){
                                        return back()->with('message','Stock has been Updated');  
                                    }else{
                                        return back()->with('message','Error'); 
                                    }


                                    return back()->with('message','Quantity you applied for is available'); 
                                }

                            }else{
                                    // else the location is warehouse so put record as update

                                    $stock = Stock::where('product_id',$request->item)
                                            ->where('location_id',$request->location)
                                            ->first();
                                    $stock->quantity += $request->quantity;
                                    $stock->recorded_at = date("Y-m-d H:i:s",strtotime($request->recorded_at));
                                    $product = Product::find($request->item);
                                    $stock_log = new StockLog;  
                                    $stock_log->quantity = $request->quantity;
                                    
                                    $stock_log->caps = (($product->cost_price + $product->carriage_price) * $request->quantity);
                                    $stock_log->expected_profit = ($product->selling_price * $request->quantity) - (($product->cost_price + $product->carriage_price)* $request->quantity);
                                    $stock_log->location_id = $request->location;
                                    $stock_log->product_id = $request->item;
                                    $stock_log->status = 1;
                                    $stock_log->entry_by = Auth::user()->id;
                                    $stock_log->type = "Update";
                                    $stock_log->recorded_at = date("Y-m-d H:i:s",strtotime($request->recorded_at));
                                    $stock_log->save();

                                    if($stock->save()){
                                        return back()->with('message','Stock has been Updated');  
                                    }else{
                                        return back()->with('message','Error'); 
                                    }

                                    

                            }

                    }else {
                        // if the product  does not exists in location then its an new

                            // check for quantity in warehouse
                            $stockw = Stock::where('product_id',$request->item)
                            ->where('location_id',1)
                            ->first();

                            if ($request->quantity > $stockw->quantity) {
                                return back()->with('message','The Quantity you applied for is not available');  
                            }else {

                                $stock = new Stock;
                                $stock->product_id = $request->item;
                                // $stock->quantity = $request->quantity;
                                $stock->quantity = 0;
                                $stock->location_id = $request->location;
                                // $stockw->quantity-= $request->quantity;
                                // $stockw->save();
                                $stock->recorded_at = date("Y-m-d H:i:s",strtotime($request->recorded_at));
                                $product = Product::find($request->item);
                                $stock_log = new StockLog;  
                                $stock_log->quantity = $request->quantity;
                                $stock_log->caps = (($product->cost_price + $product->carriage_price) * $request->quantity);
                                $stock_log->expected_profit = ($product->selling_price * $request->quantity) - (($product->cost_price + $product->carriage_price) * $request->quantity);
                                $stock_log->location_id = $request->location;
                                $stock_log->entry_by = Auth::user()->id;
                                $stock_log->type = "New Record";
                                $stock_log->product_id = $request->item;
                                $stock_log->recorded_at = date("Y-m-d H:i:s",strtotime($request->recorded_at));
                                $stock_log->save();


                                
                                if($stock->save()){
                                return back()->with('message','New Stock has been Added');
                                }else{
                                    return back()->with('message','Error'); 
                                }
                            }
                        
                           

                    }


        }else {
            if($request->location == 1){

                $stock = new Stock;
                $stock->product_id = $request->item;
                $stock->quantity = $request->quantity;
                $stock->location_id = $request->location;
                $stock->recorded_at = date("Y-m-d H:i:s",strtotime($request->recorded_at));
                $product = Product::find($request->item);
                $stock_log = new StockLog;  
                $stock_log->quantity = $request->quantity;
                $stock_log->caps = (($product->cost_price + $product->carriage_price) * $request->quantity);
                $stock_log->expected_profit = ($product->selling_price * $request->quantity) - (($product->cost_price + $product->carriage_price) * $request->quantity);
                $stock_log->location_id = $request->location;
                $stock_log->entry_by = Auth::user()->id;
                $stock_log->type = "New Record";
                $stock_log->product_id = $request->item;
                $stock_log->status = 1;
                $stock_log->recorded_at = date("Y-m-d H:i:s",strtotime($request->recorded_at));
                $stock_log->save();
                if($stock->save()){
                return back()->with('message','New Stock has been Added');
                }else{
                    return back()->with('message','Error'); 
                }

            }else {
                return back()->with('message','Error:Cant add stock Please Add Stock in Warehouse Records First');
            }


        }



    }

    public function stock_in() : View {
        $stocks = StockLog::where('location_id',Auth::user()->location_id)->orderBy('created_at','desc')->get();
        return view('stock_in',compact('stocks'));
    }

    public function approve_stock($id){
        $stocklog = StockLog::find($id);
        $stocklog->status = 1;
        $quantity = $stocklog->quantity;
        $stock = Stock::where('product_id',$stocklog->product_id)->where('location_id',Auth::user()->location_id)->first();
        $stockw = Stock::where('product_id',$stocklog->product_id)->where('location_id',1)->first();
        $stockw->quantity -= $quantity;
        $stock->quantity += $quantity;
        $stock->save();
        $stockw->save();
        $stocklog->save();
        return back();
    }

    public function ledger_card($id) : View {
        $ledger = Ledger::where('location_id',Auth::user()->location_id)->where('product_id',$id)->get();
        return view('ledger_card',compact('ledger'));
    }

    public function update_ledger(Request $request){
        $today = Carbon::today();

        if(Ledger::where('location_id',Auth::user()->location_id)->where('product_id',$request->product_id)->whereDate('created_at',$today)->exists()){
            $ledger = Ledger::where('location_id',Auth::user()->location_id)->where('product_id',$request->product_id)->whereDate('created_at',$today)->first();
            $ledger->received = $request->received;
            $ledger->supplied = $request->supplied;
            $ledger->balance = $request->balance;
            $ledger->save();
            return back();
        }else{

        
            $ledger =   new Ledger;
            $ledger->entry_by = Auth::user()->id;
            $ledger->location_id =Auth::user()->location_id;
            $ledger->product_id = $request->product_id;
            $ledger->received = $request->received;
            $ledger->supplied = $request->supplied;
            $ledger->balance = $request->balance;
            $ledger->save();
            return back();
        }
    }
    
    public function update_previous_ledger(Request $request){
        $today = date("Y-m-d H:i:s",strtotime($request->created_at));;

        if(Ledger::where('location_id',Auth::user()->location_id)->where('product_id',$request->product_id)->whereDate('created_at',$today)->exists()){
            $ledger = Ledger::where('location_id',Auth::user()->location_id)->where('product_id',$request->product_id)->whereDate('created_at',$today)->first();
            $ledger->received = $request->received;
            $ledger->supplied = $request->supplied;
            $ledger->balance = $request->balance;
            $ledger->save();
            return back();
        }else{

        
            $ledger =   new Ledger;
            $ledger->entry_by = Auth::user()->id;
            $ledger->location_id =Auth::user()->location_id;
            $ledger->product_id = $request->product_id;
            $ledger->received = $request->received;
            $ledger->supplied = $request->supplied;
            $ledger->balance = $request->balance;
            $ledger->created_at = date("Y-m-d H:i:s",strtotime($request->created_at));
            $ledger->updated_at = date("Y-m-d H:i:s",strtotime($request->created_at));
            $ledger->save();
            return back();
        }
    }

    public static function compute_ledger($id){
        $today = Carbon::today();
        
        $received = StockLog::where('product_id',$id)->where('location_id',Auth::user()->location_id)
        ->where(function ($query) {
                $query->whereDate('created_at',Carbon::today())
                      ->orWhereDate('updated_at',Carbon::today());
            })->sum('quantity');
        if(Auth::user()->location_id == 1){
            $stock = Stock::where('product_id',$id)->where('location_id',1)->first();
            $balance = $stock->quantity;
            $supplied = StockLog::where('product_id',$id)->where('location_id','!=',Auth::user()->location_id)->whereDate('created_at',$today)->sum('quantity');
        }else{
            $stock = Stock::where('product_id',$id)->where('location_id',Auth::user()->location_id)->first();
            $stock_id = $stock->id;
            $balance = $stock->quantity;
            $supplied = Sale::where('stock_id',$stock_id)->where('location_id',Auth::user()->location_id)->whereDate('created_at',$today)->sum('quantity');
            
        }

        return [
            'received'=>$received,
            'supplied'=>$supplied,
            'balance'=>$balance
        ];


    }
    
    public static function compute_ledger2($id,$sid,$lid){
        $today = Carbon::today();
        
        // $received = StockLog::where('product_id',$id)->where('location_id',$lid)->whereDate('created_at',$today)->sum('quantity');
        
        $received = StockLog::where('product_id',$id)->where('location_id',$lid)
        ->where(function ($query) {
                $query->whereDate('created_at',Carbon::today())
                      ->orWhereDate('updated_at',Carbon::today());
            })->sum('quantity');
            
            
            $stock = Stock::find($sid);
            $stock_id = $stock->id;
            $balance = $stock->quantity;
            $supplied = Sale::where('stock_id',$stock_id)->where('location_id',$lid)->whereDate('created_at',$today)->sum('quantity');
            

        return [
            'received'=>$received,
            'supplied'=>$supplied,
            'balance'=>$balance,
        ];


    }


    public function requisitions():View{
        $requisitions = Requisition::all();
        $stocks = Stock::all();
        $products = Product::where('id','!=',0)->where('products.cost_price','>',10)
                    ->get();
        return view('requisitions',compact('requisitions','stocks','products'));
    }

    public function new_requisition(Request $request){
       $requisition = new Requisition;
       $requisition->product_id = $request->product_id;
       $requisition->initiated_by = Auth::user()->id;
       $requisition->quantity_requested = $request->quantity;
       $requisition->status = 0;
       $requisition->location_id = Auth::user()->location_id;

       if($requisition->save()){
        return back()->with('message','Requisition has been sent');
       }else{
        return back()->with('message','Error'); 

        }

    }
    public function verify_requisition($id){
        $requisition = Requisition::find($id); 
        // $requisition->status = 1;
        // $stock = Stock::find($requisition->stock_id);
        // $stock->quantity += $requisition->quantity;
        // $product = Product::find($stock->product_id);
        // $stock->caps += ($product->cost_price * $requisition->quantity);
        // $stock->expected_profit += ($product->selling_price * $requisition->quantity) - ($product->cost_price * $requisition->quantity);
        // $stock->save();
        // $requisition->save();
        // return back();

        return view('req_approval',compact('requisition'));
    }

    public function req_stock(){
        $requisition = Requisition::find($id); 
        // $requisition->status = 1;
        // $stock = Stock::find($requisition->stock_id);
        // $stock->quantity += $requisition->quantity;
        // $product = Product::find($stock->product_id);
        // $stock->caps += ($product->cost_price * $requisition->quantity);
        // $stock->expected_profit += ($product->selling_price * $requisition->quantity) - ($product->cost_price * $requisition->quantity);
        // $stock->save();
        // $requisition->save();
        // return back();

        return view('req_approval',compact('requisition'));
    }



    public function expenses():View{
        $expenses = Expense::all();
        return view('expenses',compact('expenses'));
    }

    public function new_expense(Request $request){
       $expense = new Expense;
       $expense->entry_by = Auth::user()->id;
       $expense->location_id = Auth::user()->location_id;
       $expense->item = $request->item;
       $expense->amount = $request->amount;

       if($expense->save()){
        return back()->with('message','Expense has been Added');
       }else{
        return back()->with('message','Error'); 
        }

    }
    public function sales():View{
        $sales = Sale::all();
        return view('sales',compact('sales'));
    }

    public function vipsales():View{
        $sales = VipSale::all();
        return view('vipsales',compact('sales'));
    }

    public function cashbook():View{
        $locations = Location::all(); 
        return view('cashbook',compact('locations'));
    }

    public function cashbookview(Request $request,$id):View{
        if ($request->date == '') {
            $today = Carbon::today();
            $location = Location::find($id);
            $sales = Sale::where('location_id',$id)->whereDate('created_at',$today)->get();
            $gross_profit = Sale::where('location_id',$id)->whereDate('created_at',$today)->sum('profit');
            $expenses = Expense::where('location_id',$id)->whereDate('created_at',$today)->get();
            $gross_expenses = Expense::where('location_id',$id)->whereDate('created_at',$today)->sum('amount');
            $profit =  $gross_profit - $gross_expenses;
            return view('cashbookview',compact('sales','expenses','location','gross_profit','gross_expenses','profit')); 
        }else {
            
        $date = $request->date;
        $location = Location::find($id);
        $sales = Sale::where('location_id',$id)->whereDate('created_at',$date)->get();
        $expenses = Expense::where('location_id',$id)->whereDate('created_at',$date)->get();
        $gross_profit = Sale::where('location_id',$id)->whereDate('created_at',$date)->sum('profit');
        $gross_expenses = Expense::where('location_id',$id)->whereDate('created_at',$date)->sum('amount');
        $profit =  $gross_profit - $gross_expenses;
        return view('cashbookview',compact('sales','expenses','location','gross_profit','gross_expenses','profit'));
        }
    }

    
    public function products():View{
        $products = Product::orderBy('item','ASC')->get();
        return view('products',compact('products'));
    }

    public function new_product(Request $request){
       $product = new Product;
       $product->item = $request->item;
       $product->cost_price = $request->cost_price;
       $product->carriage_price = $request->carriage_price;
       $product->selling_price = $request->selling_price;
       if($product->save()){
        return back()->with('message','Item has been Added');
        }else{
            return back()->with('message','Error'); 
        }

    }

    public function update_product(Request $request){
        $product = Product::find($request->product_id);
        $product->cost_price = $request->cost_price;
        $product->carriage_price = $request->carriage_price;
        $product->selling_price = $request->selling_price;
        if($product->save()){
         return back()->with('message','Item has been Updated');
         }else{
             return back()->with('message','Error'); 
         }
 
     }
    public function customers():View{
        $customers = Customer::all();
        return view('customers',compact('customers'));
    }

    public function new_customer(Request $request){
        $customer = new Customer;
        $customer->fullname = $request->fullname;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        if ($customer->save()) {
            return back()->with('message','New Customer has been added!!');
        }else{
            return back()->with('message','Failed!!');
        }

    }

    public function vipcustomers():View{
        $customers = VipCustomer::all();
        return view('vipcustomers',compact('customers'));
    }

    public function new_vipcustomer(Request $request){
        $customer = new VipCustomer;
        $customer->fullname = $request->fullname;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        if ($customer->save()) {
            return back()->with('message','New Customer has been added!!');
        }else{
            return back()->with('message','Failed!!');
        }

    }
    public function places():View{
        $locations = Location::all();
        return view('places',compact('locations'));
    }

    public function new_place(Request $request){
        $location = new Location;
        $location->place = $request->place;
        $location->address = $request->address;
        if ($location->save()) {
            return back()->with('message','New Place has been added!!');
        }else{
            return back()->with('message','Failed!!');
        }

    }
    public function settings():View{
        return view('settings');
    }

    public function change_password(Request $request){
        $id = Auth::user()->id;
        $email = Auth::user()->email; 
        $cpass = $request->input('cpass') ;
        $npass = $request->input('npass') ;
        $vpass = $request->input('vpass') ;

        if(Hash::check($cpass,Auth::user()->password)){
            if($npass == $vpass){
                User::where('id', $id)
               ->update(['password' => Hash::make($npass)]);
               
                $message = "Password has been Updated!";
                return back()->with('message',$message);
           }else{
            $message = "Passwords are not the same!";
            return back()->with('message',$message);
           }
        }else{
            $message = "Please Enter the Current Password!";
            return back()->with('message',$message);
        }

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }


}


