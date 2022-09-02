<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Carrito;
use App\Entidades\Categoria;
use App\Entidades\Sistema\Patente; //controles de permisos
use App\Entidades\Sistema\Usuario; //controles de permisos
use Illuminate\Http\Request;
use App\Entidades\Pedido;

require app_path() . '/start/constants.php';

class ControladorEliminarProducto extends Controller
{
      // public function destroy($id)
      // {
      //       $titulo = "Eliminar producto";
      //       $item = new Producto();
      //       $item->delete();

      //       return back()-> with('succes','Producto eliminado correctamente');
      // }

      public function eliminarProducto(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("PRODUCTOELIMINAR")) {

                $entidad = new Producto();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "PRODUCTOELIMINAR";
                $aResultado["err"] = "No tiene pemisos para la operación.";
            }
            echo json_encode($aResultado);
        } else {
            return back()-> with('succes','Producto eliminado correctamente');
        }
    }
}
