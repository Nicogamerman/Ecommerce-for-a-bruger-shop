<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\Categoria;
use App\Entidades\Sucursal;
use App\Entidades\Postulacion;
use App\Entidades\Carrito;
use App\Entidades\Carrito_producto;
use Session;

class ControladorWebContacto extends Controller
{
   
    public function index()
    {
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

       /* Returning the view called "web.contacto" with the variables. */
        $pg = "contacto";
        return view("web.contacto", compact('pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));
    }
   
    public function agregarAlCarrito(Request $request){
       /* Creating a new instance of the Producto class and then calling the obtenerTodos() method on
       it. */
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $pg = "contacto";
        
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

            return view("web.contacto", compact('msg', 'pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));
            
        } else { 
            
            $msg["estado"] = "danger";
            $msg["mensaje"] = "Antes de agregar un producto a tu carrito, debes loguearte.";
            return view("web.contacto", compact('msg', 'pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));
        }
        

        
    }
           
}
