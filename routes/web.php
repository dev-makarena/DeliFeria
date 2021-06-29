<?php

use App\Models\MessageDeli;
use App\Models\Pedidos;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {

    // $user = Auth::user();
    // if (isset($user)) {
    //     if ($user->esVendedor()) {
    //         echo "Eres Vendedor";
    //     } else {
    //         echo "Eres Cliente";
    //     }
    // }

    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard/{id}', [App\Http\Controllers\DeliferiaController::class, 'dashboard'])->name('dashboard');

Route::get('/home', function () {
    $vendedores = "";
    $mensajes = "";
    if (Auth::user()->role_id == 2) {
        $data = Product::where('id_seller', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
        $pedidos = Pedidos::where('id_vendedor', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
        $mensajes = MessageDeli::where('id_vendedor', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
    }
    if (Auth::user()->role_id == 1) {
        $vendedores = User::where('role_id', '=', 2)->orderBy('id', 'desc')->get();
        $pedidos = Pedidos::where('id_cliente', '=', Auth::user()->id)->orderBy('id', 'desc')->get();

        $mensajes = MessageDeli::where('id_cliente', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
    }



    return view('home-space', compact('vendedores', 'mensajes', 'pedidos'));
})->name('home-space');


Route::get('/usr', function () {
    return DB::table('users')->get();
});

Route::get('/upd', function () {
    return DB::table('pedidos')->get();
});
Route::get('/pro', function () {
    return DB::table('products')->get();
});


Route::get('/test', function () {
    // return DB::table('products')->get();
    // return Pedidos::all();
    return MessageDeli::all();

    // return Pedidos::where('id_vendedor', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
    // return DB::table('users')
    //     ->where('id', '=', 2)
    //     ->update([
    //         "role_id" => 2,
    //         // "active" => "$request->input('active')",
    //         // "order" => $request->input('order'),
    //     ]);
});

Route::get('/productdel', [App\Http\Controllers\ProductController::class, 'deleteProduct'])->name('product.del');
Route::post('/productadd', [App\Http\Controllers\ProductController::class, 'addProduct'])->name('product.add');
Route::get('/productget', [App\Http\Controllers\ProductController::class, 'getProduct'])->name('product.get');
Route::get('/productedit', [App\Http\Controllers\ProductController::class, 'editProduct'])->name('product.edit');

Route::post('/pedidoadd', [App\Http\Controllers\pedidosController::class, 'addPedido'])->name('pedido.add');
Route::post('/pedidostatus', [App\Http\Controllers\pedidosController::class, 'statusPedido'])->name('pedido.status');
Route::post('/pedidodelete', [App\Http\Controllers\pedidosController::class, 'deletePedido'])->name('pedido.delete');


Route::post('/messagesend', [App\Http\Controllers\MessageDeliController::class, 'sendMessage'])->name('message.send');
