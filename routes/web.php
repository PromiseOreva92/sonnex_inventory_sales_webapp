<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class,'login']);
Route::get('login', [UserController::class,'login'])->name('login');
Route::post('login_user', [UserController::class,'authuser'])->name('login_user');
Route::get('newuser', [UserController::class,'newuser'])->name('newuser');
Route::post('add_user', [UserController::class,'add_user'])->name('add_user');
Route::get('dashboard', [UserController::class,'dashboard'])->name('dashboard')->middleware('auth');
Route::get('entries', [UserController::class,'entries'])->name('entries')->middleware('auth');
Route::post('add_entry', [UserController::class,'add_entry'])->name('add_entry');
Route::get('customers', [UserController::class,'customers'])->name('customers')->middleware('auth');
Route::post('new_customer', [UserController::class,'new_customer'])->name('new_customer');

Route::post('update_user', [UserController::class,'update_user'])->name('update_user');

Route::get('vipcustomers', [UserController::class,'vipcustomers'])->name('vipcustomers')->middleware('auth');
Route::post('new_vipcustomer', [UserController::class,'new_vipcustomer'])->name('new_vipcustomer');

Route::get('users', [UserController::class,'users'])->name('users')->middleware('auth');
Route::post('new_user', [UserController::class,'new_user'])->name('new_user');
Route::get('invoices', [UserController::class,'invoices'])->name('invoices')->middleware('auth');
Route::post('new_invoice', [UserController::class,'new_invoice'])->name('new_invoice');

Route::get('vipinvoices', [UserController::class,'vipinvoices'])->name('vipinvoices')->middleware('auth');
Route::post('new_vipinvoice', [UserController::class,'new_vipinvoice'])->name('new_vipinvoice');

Route::get('places', [UserController::class,'places'])->name('places')->middleware('auth');
Route::post('new_place', [UserController::class,'new_place'])->name('new_place');

Route::get('stocks', [UserController::class,'stocks'])->name('stocks')->middleware('auth');
Route::get('stock_view/{id}', [UserController::class,'stock_view'])->middleware('auth');
Route::get('stock_record/{id}', [UserController::class,'stock_record'])->middleware('auth');
Route::post('new_stock', [UserController::class,'new_stock'])->name('new_stock');

Route::get('weighbill', [UserController::class,'weighbill'])->name('weighbill')->middleware('auth');
Route::post('new_weighbill', [UserController::class,'new_weighbill'])->name('new_weighbill');
Route::post('update_weighbill', [UserController::class,'update_weighbill'])->name('update_weighbill');
Route::get('confirm_weighbill/{id}', [UserController::class,'confirm_weighbill'])->name('confirm_weighbill');
Route::get('delete_weighbill/{id}', [UserController::class,'delete_weighbill'])->name('delete_weighbill');



Route::get('ledger_card/{id}', [UserController::class,'ledger_card'])->name('ledger_card')->middleware('auth');
Route::post('update_ledger', [UserController::class,'update_ledger'])->name('update_ledger');
Route::post('update_previous_ledger', [UserController::class,'update_previous_ledger'])->name('update_previous_ledger');

Route::get('stock_logs', [UserController::class,'stock_logs'])->name('stock_logs')->middleware('auth');
Route::get('stock_in', [UserController::class,'stock_in'])->name('stock_in')->middleware('auth');
Route::get('approve_stock/{id}', [UserController::class,'approve_stock'])->name('approve_stock')->middleware('auth');


Route::get('sales', [UserController::class,'sales'])->name('sales')->middleware('auth');
Route::get('vipsales', [UserController::class,'vipsales'])->name('vipsales')->middleware('auth');

Route::get('cashbook', [UserController::class,'cashbook'])->name('cashbook')->middleware('auth');
Route::get('cashbookview/{id}', [UserController::class,'cashbookview'])->name('cashbookview')->middleware('auth');



Route::get('expenses', [UserController::class,'expenses'])->name('expenses')->middleware('auth');
Route::post('new_expense', [UserController::class,'new_expense'])->name('new_expense');

Route::get('products', [UserController::class,'products'])->name('products')->middleware('auth');
Route::post('new_product', [UserController::class,'new_product'])->name('new_product');
Route::post('update_product', [UserController::class,'update_product'])->name('update_product');

Route::get('requisitions', [UserController::class,'requisitions'])->name('requisitions')->middleware('auth');
Route::post('new_requisition', [UserController::class,'new_requisition'])->name('new_requisition');
Route::get('verify_requisition/{id}', [UserController::class,'verify_requisition'])->name('verify_requisition')->middleware('auth');


Route::get('invoice_view/{id}', [UserController::class,'invoice_view'])->name('invoice_view')->middleware('auth');
Route::get('invoice_print/{id}', [UserController::class,'invoice_print'])->name('invoice_print')->middleware('auth');
Route::get('approve/{id}', [UserController::class,'approve'])->name('approve')->middleware('auth');


Route::get('balance_view/{id}', [UserController::class,'balance_view'])->name('balance_view')->middleware('auth');
Route::get('balance_print/{id}', [UserController::class,'balance_print'])->name('balance_print')->middleware('auth');
Route::post('add_balance', [UserController::class,'add_balance'])->name('add_balance')->middleware('auth');


Route::get('settings', [UserController::class,'settings'])->name('settings')->middleware('auth');
Route::post('change_password', [UserController::class,'change_password'])->name('change_password');
Route::get('logout', [UserController::class,'logout'])->name('logout');



