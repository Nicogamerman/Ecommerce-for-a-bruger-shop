<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\Categoria;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Carrito;
use App\Entidades\Carrito_producto;
use Session;

class ControladorWebCarrito extends Controller
{
    public function index()
    {        
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $cliente = new Cliente();
        Session:: put('idcliente', $cliente->idcliente);
        $idcliente = Session:: get("idcliente");

        $pg = "carrito";
        return view("web.carrito", compact('pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));
    }
}
?>