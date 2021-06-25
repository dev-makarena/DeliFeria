<?php

use App\Models\Product;
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

    $user = Auth::user();
    if (isset($user)) {
        if ($user->esVendedor()) {
            echo "Eres Vendedor";
        } else {
            echo "Eres Cliente";
        }
    }

    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $data = Product::orderBy('id', 'desc')->get();
    return view('dashboard', compact('data'));

    // return view('dashboard');
})->name('dashboard');


Route::get('/usr', function () {
    return DB::table('users')->get();
});

Route::get('/upd', function () {
    return DB::table('users')->get();
});


Route::get('/test', function () {
    // return DB::table('products')->get();
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
