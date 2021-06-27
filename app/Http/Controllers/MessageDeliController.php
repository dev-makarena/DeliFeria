<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageDeliController extends Controller
{
    public function getAll()
    {
        return DB::table('message')->get();
    }

    public function getMessages()
    {
        return DB::table('message')->where('vendedor', '=', Auth::user()->id)->get();
    }

    // 
    public function filterMessage(Request $request)
    {
        $id = $request->input('id');

        return DB::table('message')->where('id', '=', $id)->get();
    }

    public function sendMessage(Request $request)
    {
        $idPedido = $request->input('idPedido');
        $mensaje = "Pedido N°{$idPedido}: " . $request->input('message');

        $resp = DB::table('message_delis')->insert([
            'id_cliente' => $request->input('idCliente'),
            'id_vendedor' => $request->input('idVendedor'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'message' => $mensaje,
            'status' => $request->input('status'),
            "created_at" => Carbon::now()->toDateTimeString(),
            "updated_at" => Carbon::now()->toDateTimeString(),
        ]);


        return back()->with('info', 'mensaje enviado');
    }

    public function deleteMessage(Request $request)
    {
        $id = $request->id;
        $resp = DB::table('message')
            ->select('pedidos.*')
            ->Where('pedidos.id', '=', $id)->delete();

        if ($resp == 1) {
            $resp == "Message eliminado!";
        } else {
            $resp == "error al borrar";
        }


        return $resp;
    }

    public function statusMessage(Request $request)
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
            case "suspendido":
                $status = "activo";
                break;
            default:
                $status = "activo";
        }

        $resp =   DB::table('message')
            ->where('id', '=', $id)
            ->update([
                "estado" => $status,
            ]);
        return $status;
    }
}
