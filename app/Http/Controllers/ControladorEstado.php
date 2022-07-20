<?php

namespace App\Http\Controllers;

use App\Entidades\Estado;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;//controles de permisos
use App\Entidades\Sistema\Usuario;//controles de permisos
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorEstado extends Controller
{
    public function nuevo()
    {
      $titulo = "Nuevo Estado";
      return view('estado.estado-nuevo', compact('titulo'));
      } 
}
