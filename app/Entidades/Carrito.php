<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model{

      protected $table = 'carritos';
      public $timestamps = false;
  
      protected $fillable = [
          'idcarrito',
          'fk_idcliente'
      ];
  
      protected $hidden = [  
      ];

    public function guardar() {
        $sql = "UPDATE $this->table SET
            idcarrito='$this->idcarrito',
            fk_idcliente='$this->fk_idcliente',           
            WHERE idcarrito=?";
        $affected = DB::update($sql, [$this->idcarrito]);
    }
    
    public function obtenerPorId($idcarrito)
    {
        $sql = "SELECT
                idcarrito,
                fk_idcliente               
                FROM carritos WHERE idcarrito = $idcarrito";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcarrito = $lstRetorno[0]->idcarrito;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;                     
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  idcarrito,
                  fk_idcliente               
                FROM carritos A ORDER BY idcarrito";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
 
    public function obtenerPorCliente($idcliente){
        $sql = "SELECT
                   idcarrito,
                   fk_idcliente
               FROM carritos WHERE fk_idcliente = $idcliente";
       $lstRetorno = DB::select($sql);
   
     /* Checking if the query returns any data. If it does, it will return the data. If it doesn't, it
     will return null. */
       if (count($lstRetorno) > 0) {
           $this->idcarrito = $lstRetorno[0]->idcarrito;
           $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
           return $this;
       }
       return null;
     }

     public function insertar(){
        $sql = "INSERT INTO $this->table (            
            idcarrito,
            fk_idcliente
            ) VALUES (?,?)";
        $result = DB::insert($sql, [
            $this->idcarrito,
            $this->fk_idcliente,             
        ]);
        return $this->idcarrito = DB::getPdo()->lastInsertId();
    }

    // boton eliminar producto del carrito
    public function eliminarProducto()
    {
        // $sql = "DELETE FROM $this->table(
        //     imagen, 
        //     precio, 
        //     cantidad, 
        //     total,
        //     descripcion, 
        //     fk_idcliente,
        //     fk_idestado
        //     )VALUES (?,?,?,?,?,?,?)";    
        // $result = DB::delete($sql,[ 
        // $this->imagen,
        // $this->precio,
        // $this->cantidad,
        // $this->total,
        // $this->descripcion,
        // $this->fk_idcliente,
        // $this->fk_idestado,
        // ]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM pedidos WHERE idcarrito=?";
        $affected = DB::delete($sql, [$this->idcarrito]);
    }

    public function obtenerProductos()
    {
        $sql = "SELECT
                idproducto,
                nombre,
                cantidad,
                precio,
                imagen,
                fk_idcategoria,
                descripcion
                FROM $this->table ORDER BY idproducto";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function eliminarPorCliente($idCliente)
    {
        $sql = "DELETE FROM $this->table WHERE idcliente=?";
        $affected = DB::delete($sql, [$idCliente]);
    }
    
 
}

