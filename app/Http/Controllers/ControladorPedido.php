<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Estado;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;//controles de permisos
use App\Entidades\Sistema\Usuario;//controles de permisos
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPedido extends Controller
{
    public function nuevo()
    {
      $titulo = "Nuevo Pedido";
      $sucursal = new Sucursal ();
      $aSucursales = $sucursal -> obtenertodos();

      $cliente = new Cliente ();
      $aClientes = $cliente -> obtenertodos();

      $estado = new Estado ();
      $aEstados = $estado -> obtenertodos(); //Nelson coloco en singular el array.
  
      return view('pedido.pedido-nuevo', compact('titulo','aSucursales','aClientes','aEstados'));
      } 

      public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Pedido";
            $entidad = new Pedido();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->fk_idcliente == ""||$entidad->fecha == ""||$entidad->total == "") {
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
                
                $_POST["id"] = $entidad->idpedido;
                return view('pedido.pedido-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
 
        $id = $entidad->pedido;
        $pedido = new Pedido();
        $pedido->obtenerPorId($id);

        return view('pedido.pedido-nuevo', compact('msg', 'pedido', 'titulo')) . '?id=' . $pedido->idpedido;

    }
} 

 