<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;

require app_path() . '/start/constants.php';

/* A class that is used to create a new branch. */
class ControladorWebMercadopago extends Controller
{
     public function aprobar($idCliente);
     {
      $pedido= new Pedido();
      $pedido-> aprobar ($idCliente);
      return redirect("/mi-cuenta");
     } 

     public function pendiente();
     {
      $pedido= new Pedido();
      $pedido-> pendiente ($idCliente);
      return redirect("/mi-cuenta");
     }

     public function error();
     {
      $pedido= new Pedido();
      $pedido-> error ($idCliente);
      return redirect("/mi-cuenta");
     } 
}