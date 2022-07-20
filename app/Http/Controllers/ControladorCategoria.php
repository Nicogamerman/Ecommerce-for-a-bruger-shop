<?php

namespace App\Http\Controllers;

use App\Entidades\Categoria;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;//controles de permisos
use App\Entidades\Sistema\Usuario;//controles de permisos
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCategoria extends Controller
{
    public function nuevo()
    {
      $titulo = "Nueva Categoria";
      return view('categoria.categoria-nuevo', compact('titulo'));
      } 
}
