<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Carrito;
use App\Entidades\Categoria;
use App\Entidades\Sistema\Patente; //controles de permisos
use App\Entidades\Sistema\Usuario; //controles de permisos
use Illuminate\Http\Request;
use App\Entidades\Pedido;
use Illuminate\Contracts\Session\Session;


require app_path() . '/start/constants.php';

class ControladorEliminarProducto extends Controller
{

      public function eliminar(){
            $sql = "DELETE FROM $this->table WHERE
                idcategoria=?";
            $affected = DB::delete($sql, [$this->idcategoria]);
        }
      
//       public function eliminarProducto(Request $request)
//     {      
       
//         if (Usuario::autenticado() == true) {
//             if (Patente::autorizarOperacion("PRODUCTOELIMINAR")) {

//                 $entidad = new Producto();
//                 $entidad->cargarDesdeRequest($request);
//                 $entidad->eliminar();

//                 $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
//             } else {
//                 $codigo = "PRODUCTOELIMINAR";
//                 $aResultado["err"] = "No tiene pemisos para la operación.";
//             }
//             echo json_encode($aResultado);
//         } else {
//             return back()-> with('succes','Producto eliminado correctamente');
//         }
        
//     }

      // public function eliminar(Request $request){
      //       $id = $request->input('id');

      //       if (Usuario::autenticado() == true) {
      //       if (Patente::autorizarOperacion("CARRITOBAJA")) {

      //             $entidad = new Carrito();
      //             $entidad->cargarDesdeRequest($request);
      //             $entidad->eliminar();

      //             $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
      //       } else {
      //             $codigo = "ELIMINARCARRITO";
      //             $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
      //       }
      //       echo json_encode($aResultado);
      //       } else {
      //       return redirect('carrito');
      //       }
      // }

            // public function destroy($id)
            // {
            //       Carrito::destroy($id);

            //       return view('carrito');
            // }

}
