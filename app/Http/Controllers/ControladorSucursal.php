<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;//controles de permisos
use App\Entidades\Sistema\Usuario;//controles de permisos
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorSucursal extends Controller
{
    public function nuevo()
    {
      $titulo = "Nueva Sucursal";
      return view('sucursal.sucursal-nuevo', compact('titulo'));
      }

      public function index()
      {
          $titulo = "Listado de Sucursales";
          if (Usuario::autenticado() == true) {
              if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                  $codigo = "MENUCONSULTA";
                  $mensaje = "No tiene permisos para la operaci&oacute;n.";
                  return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
              } else {
                  return view('sucursal.sucursal-listar', compact('titulo'));
              }
          } else {
              return redirect('admin/login');
          }
      }

      public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Sucursal";
            $entidad = new Sucursal();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }       
                
                $_POST["id"] = $entidad->idsucursal;
                return view('sucursal.sucursal-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->sucursal;
        $sucursal = new Sucursal();
        $sucursal->obtenerPorId($id);

        return view('sucursal.sucursal-nuevo', compact('msg', 'sucursal', 'titulo')) . '?id=' . $sucursal->idsucursal;

    }
}
