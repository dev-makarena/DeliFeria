<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProducts()
    {
        return DB::table('products')->where('id_seller', '=', Auth::user()->id)->get();
    }
    public function getProduct(Request $request)
    {
        $id = $request->input('id');

        return DB::table('products')->where('id', '=', $id)->get();
    }

    public function addProduct(Request $request)
    {

        DB::table('products')->insert([
            "id_seller" => Auth::user()->id, ///////////////////////////////////////////////////////////////////////////////////////////
            "name" => $request->input('name'),
            "description" => $request->input('description'),
            "price" => $request->input('price'),
            "img_url" => $request->input('img_url'),
            "categoria" => "test",
            "active" => 1,
            "order" => 1,
            // "active" => $request->input('active'),
            // "order" => $request->input('order'),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        $resp = "listo";
        return redirect('dashboard');
    }

    public function deleteProduct(Request $request)
    {
        $idDelete = $request->input('idDelete');
        $resp = DB::table('products')
            ->select('products.*')
            ->Where('products.id', '=', $idDelete)->delete();

        if ($resp == 1) {
            $resp == "borrado";
        } else {
            $resp == "error al borrar";
        }


        return redirect()->back();
        // return view('vendedor', compact('resp'));
    }

    public function editProduct(Request $request)
    {
        $id = $request->input('idinput');

        $resp =   DB::table('products')
            ->where('id', '=', $id)
            ->update([
                // "id" => $id,
                // "id_seller" => Auth::user()->id,
                "name" => $request->input('name'),
                "description" => $request->input('description'),
                "price" => $request->input('price'),
                "img_url" => $request->input('img_url'),
                "categoria" => "test",
                // "active" => "$request->input('active')",
                // "order" => $request->input('order'),
            ]);

        // dd($request->input('name'));
        return redirect()->back();
    }
}
