<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class pedidosController extends Controller
{
    public function getAll()
    {
        return DB::table('pedidos')->get();
    }

    public function getPedidos()
    {
        return DB::table('pedidos')->where('vendedor', '=', Auth::user()->id)->get();
    }

    // 
    public function filterPedido(Request $request)
    {
        $id = $request->input('id');

        return DB::table('pedidos')->where('id', '=', $id)->get();
    }

    public function addPedido(Request $request)
    {
        $products = $request->products;

        $date = Carbon::now();

        $resp = DB::table('pedidos')->insert([
            "created_at" => Carbon::now()->toDateTimeString(),
            "updated_at" => Carbon::now()->toDateTimeString(),
            'id_cliente' => $products[0]["id_client"],
            'nombre_cliente' => $products[0]["name_client"],
            'direccion_cliente' => $products[0]["direction_client"],
            'id_vendedor' => $products[0]["id_vendedor"],
            'precio_total' => $products[0]["precio_total"],
            'estado' => $products[0]["estado"],
            'productos' => json_encode($products[0]["products"], true),
        ]);


        return $resp;
        // $resp = "listo";
        // return redirect('zonavendedor');
    }

    public function deletePedido(Request $request)
    {
        $idDelete = $request->input('idDelete');
        $resp = DB::table('pedidos')
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

    public function statusPedido(Request $request)
    {
        $id = $request->id;
        $status = $request->input('status');
        switch ($status) {
            case "activo":
                $status = "recibido";
                break;
            case "recibido":
                $status = "en camino";
                break;
            case "en camino":
                $status = "rechazado";
                break;
            case "rechazado":
                $status = "eliminado";
                break;
            case "eliminado":
                $status = "activo";
                break;
            case "suspendido":
                $status = "activo";
                break;
            default:
                $status = "suspendido";
        }

        $resp =   DB::table('pedidos')
            ->where('id', '=', $id)
            ->update([
                "estado" => $status,
            ]);
        return $status;
    }
}
