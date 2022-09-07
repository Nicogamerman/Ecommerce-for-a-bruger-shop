<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Carrito;
use App\Entidades\Pedido;
use App\Entidades\Carrito_producto;
use Session;

use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

/* Including the constants.php file. */
require app_path() . '/start/constants.php';

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $idcliente = Session::get("idcliente");
        /* Checking if the cart is empty or not. */
        if ($idcliente > 0) {
            $carrito = new Carrito();

            /* Checking if the cart is empty or not. */
            if ($carrito->obtenerPorCliente($idcliente) != null) {
                $carrito_producto = new Carrito_producto();
                if ($carrito_producto->obtenerPorCarrito($carrito->idcarrito) != null) {
                    $idcarrito = $carrito->idcarrito;
                    $aCarrito_productos = $carrito_producto->obtenerPorCarrito($idcarrito);
                } else {
                    $aCarrito_productos = array();
                }
            }
            /* Checking if the cart is empty or not. */ 
            else {
                $msg["estado"] = "info";
                $msg["mensaje"] = "Su carrito esta vacio, agregue productos desde Takeaway";
            }

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $pg = "carrito";
            return view("web.carrito", compact('pg', 'carrito', 'carrito_producto', 'aSucursales', 'aCarrito_productos'));
        }
    }  

    /* A function that is called when the user clicks on the "Finalizar Pedido" button. */
    public function finalizarPedido(Request $request)
    {
        $pedido = new Pedido();
        $pedido->fecha = Date("Y-m-d H:i:s");
        $medioDePago =  $request->input('lstMedioDePago');

        $carrito_producto = new Carrito_producto();
        $aCarritoProductos = $carrito_producto->obtenerPorCliente(Session::get("idcliente"));

        /* Adding the product name and the price to the description and the total of the order. */
        foreach ($aCarritoProductos as $carrito) {
            $pedido->descripcion .= $carrito->producto . " - ";
            $pedido->total = $carrito->cantidad * $carrito->precio;
        }

        $pedido->fk_idsucursal = $request->input('lstSucursal');
        $pedido->fk_idcliente = Session::get("idcliente");

       /* Checking if the payment method is "sucursal" or not. If it is, it will set the order state to
       "PENDIENTE" and insert it. If it is not, it will set the order state to "PENDIENTEDEPAGO" and
       insert it. */
        if ($medioDePago == "sucursal") {
            $pedido->fk_idestado = PEDIDO_PENDIENTE;
            $pedido->insertar();
        } else {
            $pedido->fk_idestado = PEDIDO_PENDIENTEDEPAGO;
            $pedido->insertar();
        
           /* MercadoPago paying method, Setting the access token, client id. */
            $access_token = "";
            SDK::setClientId(config("payment-methods.mercadopago.client"));
            SDK::setClientSecret(config("payment-methods.mercadopago.secret"));
            SDK::setAccessToken($access_token); //token where you will recive the payment. 

            /* Creating a new item, setting the id, title, category, quantity, unit price and currency. */
            $item = new Item();
            $item->id = "1234";
            $item->title = "Burger´s SRL";
            $item->category_id = "products";
            $item->quantity = 1;
            $item->unit_price = $pedido->total;
            $item->currency_id = "ARS"; 

            $preference = new Preference();
            $preference->items = array($item);
  
           /* Setting the payer information. */
            $payer = new Payer();
            $cliente = new Cliente();
            $cliente->obtenerPorId(Session::get("idcliente"));
            $payer->name = $cliente->nombre;
            $payer->surname = $cliente->apellido;
            $payer->email = $cliente->correo;
            $payer->date_created = date('Y-m-d H:m:s');
            $payer->identification = array(
                "type" => "DNI",
                "number" => $cliente->dni,
            );
            $preference->payer = $payer;

           /* Setting the url where the user will be redirected after the payment in MercadoPago. */
            $preference->back_urls = [
                "success" => "http://127.0.0.1:8000/mercado-pago/aprobado/" . $cliente->idcliente,
                "pending" => "http://127.0.0.1:8000/mercado-pago/pendiente/" . $cliente->idcliente,
                "failure" => "http://127.0.0.1:8000/mercado-pago/error/" . $cliente->idcliente,
            ];

            $preference->payment_methods = array("installments" => 6);
            $preference->auto_return = "all";
            $preference->notification_url = '';
            $preference->save();
        }

        /* Deleting the cart and redirecting to the account page.*/
        $carrito_producto->eliminarPorCliente(Session::get("idcliente"));

        $carrito = new Carrito();
        $carrito->eliminarPorCliente(Session::get("idcliente"));

        return redirect("/mi-cuenta");
       
    }


}
