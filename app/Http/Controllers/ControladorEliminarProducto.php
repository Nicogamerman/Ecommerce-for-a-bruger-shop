<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Sistema\Patente; //controles de permisos
use App\Entidades\Sistema\Usuario; //controles de permisos
use Illuminate\Http\Request;

use Illuminate\Contracts\Session\Session;

require app_path() . '/start/constants.php';

class ControladorEliminarProducto extends Controller
{

    // public function eliminar(Request $request)
    // {
    //     $id = $request->idcarrito_producto;

    //     $carrito = new Carrito();
    //     $carrito->eliminar(request("idcarrito_producto"));
 
    //     return view("web.carrito");

    //     } 

    public function eliminar(Request $request)
        {
            $id = $request->get('idcarrito_producto');
    
            if (Usuario::autenticado() == true) {
                    $entidad = new Producto();
                    $entidad->cargarDesdeRequest($request);
                    $entidad->eliminar();
    
                return view("web.carrito");  
            }
        }
}


