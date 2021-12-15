<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\SocketController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoiceProductsController;

Auth::routes();

Route::get('/test-socket',[SocketController::class, 'test'])->name('socket.test');

Route::get('/', [InvoicesController::class, 'index'])->name('invoices.index');
Route::get('/invoices/create', [InvoicesController::class, 'create'])->name('invoices.create');
Route::post('/invoices/store',[InvoicesController::class, 'store'])->name('invoices.store');
Route::get('/invoices/{invoice}',[InvoicesController::class, 'show'])->name('invoices.show');
Route::get('/invoices/{invoice}/edit',[InvoicesController::class, 'edit'])->name('invoices.edit');
Route::patch('/invoices/{invoice}/update',[InvoicesController::class, 'update'])->name('invoices.update');
Route::delete('/invoices/{invoice}',[InvoicesController::class, 'destroy'])->name('invoices.destroy');

Route::delete('/products/{product}',[InvoiceProductsController::class, 'destroy'])->name('products.destroy');

// Route::post('/broadcasting/auth', function (Illuminate\Http\Request $req) {
//     if ($req->channel_name == 'home') {
//         return Broadcast::auth($req);
//     }
// });