<?php

namespace App\Http\Controllers;

use App\Models\MessageDeli;
use App\Models\Pedidos;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliferiaController extends Controller
{
    function dashboard($id = 1)
    {


        if (Auth::user()->role_id == 2) {
            $data = Product::where('id_seller', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
            $pedidos = Pedidos::where('id_vendedor', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
            $mensajes = MessageDeli::where('id_vendedor', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
            $user = "";
        }
        if (Auth::user()->role_id == 1) {
            $data = Product::where('id_seller', '=', $id)->orderBy('id', 'desc')->get();
            $pedidos = Pedidos::where('id_cliente', '=', Auth::user()->id)
                ->where('id_vendedor', '=', $id)
                ->orderBy('id', 'desc')->get();
            $mensajes = MessageDeli::where('id_cliente', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
            $user = User::where('id', '=', $id)->first();
        }

        // $pedidos = Pedidos::where('id', '=', '')->orderBy('id', 'desc')->get();
        return view('dashboard', compact('data', 'pedidos', 'mensajes', 'user'));

        // return view('dashboard');

    }
}
