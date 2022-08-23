<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use Session;
class ControladorWebLogin extends Controller
{
    public function index()
    {
        $pg = "login";

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.login", compact('pg', 'aSucursales'));
    }

    public function ingresar(Request $request){
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $pg = "login";
        $correo = $request->input('txtCorreo');
        $clave = $request->input('txtClave');

        $cliente = new Cliente();
        $cliente->obtenerPorCorreo($correo);


       /* Checking if the client exists and if the password is correct. */
        if($cliente->idcliente > 0 && password_verify($clave, $cliente->clave)){

            $cliente->obtenerPorId($cliente->idcliente);
            Session::put("idcliente", $cliente->idcliente);
            return view("web.bienvenido", compact('cliente', 'aSucursales'));            
        } 
        /* Returning the login page with a message. */
        else {
            $msg["msg"]= "Correo o clave incorrecto";
            $msg["estado"]= "danger";

            return view("web.login", compact('msg', 'aSucursales', 'pg'));
        }
    }
}