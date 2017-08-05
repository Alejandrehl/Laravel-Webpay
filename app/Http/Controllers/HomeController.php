<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producto = [
        	'id' => 1,
        	'nombre' => 'Mi productito',
        	'precio' => '18000',
        	'cantidad' => 1
        ];

        // Lo pongo en una sesión por la mayoría de los carritos de compras ocupan Sessiones para esto.
        \Session::put('cart', $producto);

        return view('home.index');
    }


}
