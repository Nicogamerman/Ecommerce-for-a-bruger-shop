<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;//controles de permisos
use App\Entidades\Sistema\Usuario;//controles de permisos
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorProducto extends Controller
{
    public function nuevo()
    {
      $titulo = "Nuevo Producto";
      return view('producto.producto-nuevo', compact('titulo'));
      } 
}
