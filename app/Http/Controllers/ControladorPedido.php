<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;//controles de permisos
use App\Entidades\Sistema\Usuario;//controles de permisos
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPedido extends Controller
{
    public function nuevo()
    {
      $titulo = "Nuevo Pedido";
      return view('pedido.pedido-nuevo', compact('titulo'));
      } 
}
