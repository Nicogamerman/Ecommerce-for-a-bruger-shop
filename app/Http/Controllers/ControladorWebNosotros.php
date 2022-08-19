<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\Categoria;
use App\Entidades\Sucursal;
use App\Entidades\Carrito;
use App\Entidades\Carrito_producto;
use Session;

class ControladorWebNosotros extends Controller
{
    public function index()
    {
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $pg = "nosotros";
        return view("web.nosotros", compact('pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));
    }

    public function agregarAlCarrito(Request $request){
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $pg = "nosotros";
        
        $cantidadProducto = $request->input("txtCantidadProducto");
        $idProductoSelec = $request->input("txtIdProducto");       
        $idcliente = Session::get("idcliente");
       
        if($idcliente > 0){
            $carrito = new Carrito();
            $carrito_producto = new Carrito_producto();
           
            if($carrito->obtenerPorCliente($idcliente) != null){
                $carrito_producto->fk_idcarrito = $carrito->idcarrito;
            } else {
                $carrito->fk_idcliente = $idcliente;
                $carrito->insertar();
                $carrito_producto->fk_idcarrito = $carrito->idcarrito;
            }

            $carrito_producto->fk_idproducto = $idProductoSelec;
            $carrito_producto->cantidad = $cantidadProducto;
            $carrito_producto->insertar();
            
            $msg["estado"] = "success";
            $msg["mensaje"] = "Añadiste un producto a tu carrito!";

            return view("web.nosotros", compact('msg', 'pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));
            
        } else { 
            
            $msg["estado"] = "danger";
            $msg["mensaje"] = "Antes de agregar un producto a tu carrito, debes loguearte.";
            return view("web.nosotros", compact('msg', 'pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));
        }
        

        
    }
           
}
