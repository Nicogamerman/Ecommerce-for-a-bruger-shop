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

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
        /* Creating a new instance of the Producto class and then calling the obtenerTodos() method on
       it. */
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $pg = "takeaway";
        return view("web.takeaway", compact('pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));
    }

    public function agregarAlCarrito(Request $request)
    {
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $pg = "takeaway";
        $cantidadProducto = $request->input("txtCantidadProducto");
        /* Getting the value of the hidden input with the name "txtIdProducto" and assigning it to the
       variable . */
        $idProductoSelec = $request->input("txtIdProducto");
        /* Getting the idcliente from the session. */
        $idcliente = Session::get("idcliente");

        /* Checking if the client has a cart. If he does, it assigns the id of the cart to the
                  foreign key of the cart_product table. If he doesn't, it creates a new cart and assigns
                  the id of the cart to the foreign key of the cart_product table. */
        if ($idcliente > 0) {
            $carrito = new Carrito();
            $carrito_producto = new Carrito_producto();
            /* Checking if the client has a cart. If he does, it assigns the id of the cart to the
           foreign key of the cart_product table. If he doesn't, it creates a new cart and assigns
           the id of the cart to the foreign key of the cart_product table. */
            if ($carrito->obtenerPorCliente($idcliente) != null) {
                $carrito_producto->fk_idcarrito = $carrito->idcarrito;
            } else {
                $carrito->fk_idcliente = $idcliente;
                $carrito->insertar();
                $carrito_producto->fk_idcarrito = $carrito->idcarrito;
            }

            /* Inserting the id of the product and the quantity of the product into the cart_product
            table. */
            $carrito_producto->fk_idproducto = $idProductoSelec;
            $carrito_producto->cantidad = $cantidadProducto;
            $carrito_producto->insertar();

            $msg["estado"] = "success";
            $msg["mensaje"] = "Añadiste un producto al carrito";

            return view("web.takeaway", compact('msg', 'pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));

            /* Checking if the client has a cart. If he does, it assigns the id of the cart to the
            foreign key of the cart_product table. If he doesn't, it creates a new cart and assigns
            the id of the cart to the foreign key of the cart_product table. */
        } else {
            $msg["estado"] = "danger";
            $msg["mensaje"] = "Antes de agregar un producto a tu carrito, debes iniciar sesión.";
            return view("web.takeaway", compact('msg', 'pg', 'producto', 'aProductos', 'aCategorias', 'aSucursales'));
        }
    }
}
