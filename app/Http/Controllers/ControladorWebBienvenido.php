<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;

class ControladorWebBienvenido extends Controller
{
    public function index()
    {
        $pg = "inicio";
        $sucursal = new Sucursal(); //Instanciacia de una clase = un objeto
        $aSucursales = $sucursal->obtenerTodos(); //llamo al metodo obtener todos, que me devuelve un array segun lo que tengo en la base de datos
        return view("web.bienvenido", compact('pg', 'aSucursales'));
    }
}

