<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\Categoria;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Carrito;
use App\Entidades\Carrito_producto;
use Illuminate\Support\Facades\Date;
use Session;

class ControladorWebCarrito extends Controller
{
    public function index()
    {        
        $idcliente = Session::get("idcliente");

        if($idcliente > 0){
            $carrito = new Carrito();

            if($carrito->obtenerPorCliente($idcliente)!= null){
                $carrito_producto = new Carrito_producto();
                if($carrito_producto->obtenerPorCarrito($carrito->idcarrito) != null)
                $idcarrito=$carrito->idcarrito;
                $aCarrito_productos = $carrito_producto->obtenerPorCarrito();
            }
            else{
                $msg["estado"]="info";
                $msg["mensaje"]= "Su carrito esta vacio, agregue un producto para continuar";
            }      

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $pg ="carrito";
        return view("web.carrito", compact('pg', 'carrito', 'carrito_producto', 'aSucursales'));

        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();  

        $cliente = new Cliente();
        Session:: put('idcliente', $cliente->idcliente);
        $idcliente = Session:: get("idcliente");

        $pg = "carrito";
        return view("web.carrito", compact('pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales', 'carrito'));
        }    
    }

    public function finalizarPedido(Request $request){
        $pedido= new Pedido();
        $pedido-> fecha = Date("Y-m-d H:i:s");

        $carrito_producto = new Carrito_producto();
        $aCarritosProductos= $carrito_producto-> obtenerPorCliente (Session::get("idcliente"));

        foreach($aCarritoProductos as $carrito){
            $pedido->descripcion = $carrito -> nombre;
            $pedido->total =        


        $pedido->fk_idsucursal = $request->input('lstSucursal');
        $pedido->fk_idcliente = Session::get("idcliente");
        /* Setting the value of the foreign key `fk_idestado` to the value of the constant
        `PEDIDO_PENDIENTE` that is 2 cause we defined that in the archive "constantrs.php looking on our data base the number for pending order. */
        $pedido->fk_idestado = PEDIDO_PENDIENTE;
    }
}
?>