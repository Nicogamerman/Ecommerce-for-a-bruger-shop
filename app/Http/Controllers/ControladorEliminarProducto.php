<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Carrito;
use App\Entidades\Carrito_producto;
use App\Entidades\Categoria;
use App\Entidades\Sistema\Patente; //controles de permisos
use App\Entidades\Sistema\Usuario; //controles de permisos
use Illuminate\Http\Request;
use App\Entidades\Pedido;
use Illuminate\Contracts\Session\Session;


require app_path() . '/start/constants.php';

class ControladorEliminarProducto extends Controller
{

    // public function eliminarProducto(Request $request)
    // {
    //     $id = $request->input('idcarrito_producto');

    //     if (Usuario::autenticado() == true) {
    //         if (Patente::autorizarOperacion("MENUELIMINAR")) {

    //             $entidad = new Producto();
    //             $entidad->cargarDesdeRequest($request);
    //             $entidad->eliminar();

    //             $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
    //         } else {
    //             $codigo = "ELIMINARPROFESIONAL";
    //             $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
    //         }
    //         echo json_encode($aResultado);
    //     } else {
    //         return redirect('admin/login');
    //     }
    // }
}      

