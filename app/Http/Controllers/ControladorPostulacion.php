<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;//controles de permisos
use App\Entidades\Sistema\Usuario;//controles de permisos
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller
{
    public function nuevo()
    {
      $titulo = "Nueva Postulacion";
      return view('postulacion.postulacion-nuevo', compact('titulo'));
      } 

      public function index()
      {
          $titulo = "Listado de Postulaciones";
          if (Usuario::autenticado() == true) {
              if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                  $codigo = "MENUCONSULTA";
                  $mensaje = "No tiene permisos para la operaci&oacute;n.";
                  return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
              } else {
                  return view('postulacion.postulacion-listar', compact('titulo'));
              }
          } else {
              return redirect('admin/login');
          }
      }

      public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Postulacion";
            $entidad = new Postulacion();
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
                
                $_POST["id"] = $entidad->idpostulacion;
                return view('postulacion.postulacion-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->postulacion;
        $postulacion = new Postulacion();
        $postulacion->obtenerPorId($id);

        return view('postulacion.postulacion-nuevo', compact('msg', 'postulacion', 'titulo')) . '?id=' . $postulacion->idpostulacion;

    }
}
 