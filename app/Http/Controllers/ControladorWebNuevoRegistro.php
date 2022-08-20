<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ControladorWebNuevoRegistro extends Controller
{
   /**
    * It returns a view called "web.nuevo-registro" and passes the variables  and  to
    * the view.
    * 
    * @return The view is being returned.
    */
    public function index()
    { 
        $pg = "nuevo-registro";
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.nuevo-registro", compact('pg', 'aSucursales'));
        
    }

   /**
    * If the email is already registered, it will show a message and return to the registration page.
    * If the email is not registered, it will show a message and return to the login page.
    * </code>
    * 
    * @param Request request The request object.
    * 
    * @return The view is being returned.
    */
    public function enviar(Request $request){

        $pg = "nuevo-registro";

        $nombre = $request->input('txtNombre');
        $apellido = $request->input('txtApellido');
        $correo = $request->input('txtCorreo');
        $dni = $request->input('txtDni');
        $celular = $request->input('txtCelular');
        $clave = $request->input('txtClave');

        $cliente = new Cliente();
        $cliente->obtenerPorCorreo($correo);
        if($correo==$cliente->correo){
            $msg["msg"] = "Este correo ya se ecuentra registrado";
            $msg["estado"] = "danger";
            
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            return view("web.nuevo-registro", compact('msg', 'aSucursales', 'pg'));
        }else{
            $msg["msg"] = "Se ha registrado correctamente";
            $msg["estado"] = "success";

            $cliente = new Cliente();
            $cliente->nombre = $nombre;
            $cliente->apellido = $apellido;
            $cliente->correo = $correo;
            $cliente->dni = $dni;
            $cliente->celular = $celular;
            /* Hashing the password. This is for secturity, the pw will travel encrypted */
            $cliente->clave = password_hash($clave, PASSWORD_DEFAULT);
            $cliente->insertar();

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            return view("web.login", compact('msg','aSucursales', 'pg'));
        }
    }
}