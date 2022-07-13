<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model{

      protected $table = 'productos';
      public $timestamps = false;
  
      protected $fillable = [
          'idproducto',
          'nombre',
          'cantidad',
          'precio',
          'imagen',
          'descripcion',
          'fk_idcategoria'          
      ];
  
      protected $hidden = [
  
      ];
  
    public function insertar(){
        $sql = "INSERT INTO $this->table (            
            idproducto,
            nombre,
            cantidad,
            precio,
            imagen,
            descripcion,
            fk_idcategoria
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idproducto,
            $this->nombre,
            $this->cantidad,
            $this->precio,
            $this->imagen,
            $this->descripcion,
            $this->fk_idcategoria,
        ]);
        return $this->idproucto = DB::getPdo()->lastInsertId();
    }
 
    public function guardar() {
        $sql = "UPDATE $this->table SET
            idproducto=$this->idproducto,
            nombre='$this->nombre',
            cantidad=$this->cantidad,
            precio=$this->precio,
            dni='$this->dni',
            imagen='$this->imagen'
            descripcion='$this->descripcion'
            fk_idcategoria='$this->fk_idcategoria'
            WHERE idproducto=?";
        $affected = DB::update($sql, [$this->idproducto]);
    }

    public function obtenerPorId($idproducto)
    {
        $sql = "SELECT
                idproducto,
                nombre,
                cantidad,
                precio,
                imagen,
                descripcion,
                fk_idcategoria                
                FROM productos WHERE idproducto = $idproducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->precio = $lstRetorno[0]->precio;
            $this->imagen = $lstRetorno[0]->imagen;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;            
            return $this;
        }
        return null;
    }

    public function eliminar(){
        $sql = "DELETE FROM $this->table WHERE
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idproducto,
                  A.nombre,
                  A.cantidad,
                  A.precio,
                  A.imagen,
                  A.descripcion,
                  A.fk_idcategoria                 
                FROM idproducto A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
   
    
}