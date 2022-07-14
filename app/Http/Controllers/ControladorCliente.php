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
      $titulo = "Nuevo menu";
      return view('cliente.cliente-nuevo', compact('titulo'));
      } 
}
