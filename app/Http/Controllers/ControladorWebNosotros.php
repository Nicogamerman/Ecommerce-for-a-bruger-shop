<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;

class ControladorWebNosotros extends Controller
{
    public function index()
    {
        $pg = "nosotros";
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.nosotros", compact('pg', 'aSucursales'));
    }

    public function enviar(Request $request)
    {
        $nombre = $request->input('txtNombre');
        $apellido = $request->input('txtApellido');
        $celular = $request->input('txtTelefono');
        $correo = $request->input('txtCorreo');
        $mensaje = $request->input('txtMensaje');

        $postulacion = new Postulacion();
        $postulacion->nombre= $nombre;
        $postulacion->apellido= $apellido;
        $postulacion->curriculum = "";
        $postulacion->celular= $celular;
        $postulacion->correo= $correo;
        $postulacion->mensaje= $mensaje;    
        $postulacion-> insertar();

        return redirect("/gracias-postulacion");
    }

}
