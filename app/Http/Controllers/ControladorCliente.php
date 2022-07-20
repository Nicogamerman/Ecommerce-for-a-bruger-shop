<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;//controles de permisos
use App\Entidades\Sistema\Usuario;//controles de permisos
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCliente extends Controller
{
    public function nuevo()
    {
      $titulo = "Nuevo cliente";
      return view('cliente.cliente-nuevo', compact('titulo'));
    } 

    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Cliente";
            $entidad = new Cliente();
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
                
                $_POST["id"] = $entidad->idcliente;
                return view('cliente.cliente-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->cliente;
        $cliente = new Cliente();
        $cliente->obtenerPorId($id);

        return view('cliente.cliente-nuevo', compact('msg', 'cliente', 'titulo')) . '?id=' . $cliente->idcliente;

    }
}
