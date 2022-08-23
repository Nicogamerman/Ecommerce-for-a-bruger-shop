<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Session;
class ControladorWebCambiarClave extends Controller
{
    public function index()
    {
        $pg = "Cambiar clave";
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        return view("web.cambiar-clave", compact('pg', 'aSucursales'));
    }

    public function guardar(Request $request){
      $pg = "Cambiar clave";
      $sucursal = new Sucursal();
      $aSucursales = $sucursal->obtenerTodos();

      /* Getting the value of the input with the name `txtClave` */
      $clave = $request->input('txtClave');
      $reClave = $request->input('txtReClave');

    /* Checking if the password and the re-password are the same. */
      if($clave == $reClave){
            $cliente = new Cliente();
            /* Getting the client id from the session. */
            $cliente->obtenerPorId(Session::get('idcliente'));
           /* Hashing the password. */
            $cliente->clave = password_hash($clave, PASSWORD_DEFAULT);
            $cliente->guardar();
            $msg['estado'] = "success";
            $msg['msg'] = "Clave cambiada existosamente";
            return view("web.cambiar-clave", compact('pg', 'aSucursales', 'msg'));
      } else {
            $msg['estado'] = "danger";
            $msg['msg']= "Las claves no coinciden";
            return view("web.cambiar-clave", compact('pg', 'aSucursales', 'msg'));
      }
    }
}
