<?php

namespace App\Http\Controllers;

/* Importing the classes. */
use App\Entidades\Sucursal;
use App\Entidades\Sistema\Patente;//controles de permisos
use App\Entidades\Sistema\Usuario;//controles de permisos
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

/* A class that is used to create a new branch. */
class ControladorSucursal extends Controller
{
    public function nuevo()
    {
        $titulo = "Nueva Sucursal";

        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("SUCURSALCONSULTA")) {
                $codigo = "SUCURSALCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $sucursal = new Sucursal();
                return view('sucursal.sucursal-nuevo', compact('titulo', 'sucursal'));
            }
        } else {

            return redirect('admin/login');
        }
    }

    /**
     * It returns a view if the user is authenticated and has the right permissions, otherwise it
     * redirects to the login page
     */
    public function index()
    {
        $titulo = "Listado de sucursales";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("SUCURSALCONSULTA")) {
                $codigo = "SUCURSALCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('sucursal.sucursal-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

      /**
       * It takes a request from the datatable, gets the data from the database, and returns a json
       * object with the data
       */
      public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Sucursal();
        $aSucursales = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        for ($i = $inicio; $i < count($aSucursales) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/sucursal/" . $aSucursales[$i]->idsucursal . "' class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aSucursales[$i]->telefono;
            $row[] = $aSucursales[$i]->direccion;
            $row[] = $aSucursales[$i]->linkmapa;
            $row[] = $aSucursales[$i]->nombre;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aSucursales), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aSucursales), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

      /**
       * It's a function that takes a request, creates a new entity, loads the request into the entity,
       * validates the entity, and then either inserts or updates the entity
       * 
       * @param Request request The request object.
       */
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

   /**
    * It's a function that edits a branch
    * 
    * @param id The id of the record to be edited.
    */
    public function editar($id)
    {
        $titulo = "Modificar Sucursal";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("SUCURSALEDITAR")) {
                $codigo = "SUCURSALEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $sucursal = new Sucursal();
                $sucursal->obtenerPorId($id);
                return view('sucursal.sucursal-nuevo', compact('sucursal', 'titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    /**
     * It's a function that deletes a record from the database
     * 
     * @param Request request The request object.
     */
    public function eliminar(Request $request){
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("SUCURSALBAJA")) {

                $entidad = new Sucursal();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "SUCURSALBAJA";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }
}

?>

