<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use Session;

class ControladorWebCambiarDatos extends Controller
{
      public function index()
      {
          $pg = "cambiar-datos";
  
          $sucursal = new Sucursal();
          $aSucursales = $sucursal->obtenerTodos();
  
          $cliente = new Cliente();
          $cliente->obtenerPorId(Session::get('idcliente'));
  
          return view("web.cambiar-datos", compact('pg', 'aSucursales', 'cliente'));
      }

      public function editar(Request $request)
      {
          $cliente = new Cliente();
          /* It's getting the client's data from the database. */
          $cliente->obtenerPorId(Session::get('idcliente'));

          $sucursal = new Sucursal();
         /* It's getting all the branches from the database. */
          $aSucursales = $sucursal->obtenerTodos();
  
          $pg = "cambiar-datos";  
         
          $dni = $request->input('txtDni');
          $celular = $request->input('txtCelular');
          $clave = $request->input('txtClave');
          $nombre = $request->input('txtNombre');
          $apellido = $request->input('txtApellido');
          $correo = $request->input('txtCorreo');
  
          $cliente = new Cliente();          
          $cliente->dni = $dni;
          $cliente->celular = $celular;
          $cliente->nombre = $nombre;
          $cliente->apellido = $apellido;
          $cliente->correo = $correo;
          $cliente->guardar();
          $msg["estado"] = "success";
          $msg["msg"] = "Cambios confirmados!";
  
          /* It's returning the view of the page "mi-cuenta" with the variables "msg", "aSucursales"
          and "cliente". */
          return view("web.mi-cuenta", compact('msg', 'aSucursales', 'cliente'));
      }
}