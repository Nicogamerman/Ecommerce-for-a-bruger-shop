<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Carrito_producto extends Model
{
      protected $table = 'carrito_productos';
      public $timestamps = false;

      protected $fillable = [
            'idcarritoproducto',
            'fk_idproducto',
            'fk_idcarrito',
            'cantidad'
      ];

    protected $hidden = [

    ];

      public function insertar()
    {
        $sql = "INSERT INTO $this->table (
                  fk_idproducto,
                  fk_idcarrito,
                  cantidad

            ) VALUES (?, ?, ?);";
        $result = DB::insert($sql, [
            $this->fk_idproducto,
            $this->fk_idcarrito,
            $this->cantidad
        ]);
        return $this->idcarritoproducto = DB::getPdo()->lastInsertId();
    }
    
    public function guardar() {
      $sql = "UPDATE $this->table SET
          fk_idproducto=$this->fk_idproducto,
          fk_idcarrito=$this->fk_idcarrito,
          cantidad=$this->cantidad
          WHERE idcarritoproducto=?";
      $affected = DB::update($sql, [$this->idcarritoproducto]);
  }

   public function obtenerPorId($idcarritoproducto)
  {
      $sql = "SELECT
              idcarritoproducto,
              fk_idproducto,
              fk_idcarrito,
              cantidad
              FROM $this->table WHERE idcarritoproducto = $idcarritoproducto";
      $lstRetorno = DB::select($sql);

      if (count($lstRetorno) > 0) {
          $this->idcarritoproducto = $lstRetorno[0]->idcarritoproducto;
          $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
          $this->fk_idcarrito = $lstRetorno[0]->fk_idcarrito;
          $this->cantidad = $lstRetorno[0]->cantidad;
          return $this;
      }
      return null;
  }

   public function eliminar()
  {
      $sql = "DELETE FROM $this->table WHERE idcarritoproducto=?";
      $affected = DB::delete($sql, [$this->idcarritoproducto]);
  }

   public function obtenerTodos()
  {
      $sql = "SELECT
              idcarritoproducto,
              fk_idproducto,
              fk_idcarrito,
              cantidad
              FROM $this->table ORDER BY idcarritoproducto";
      $lstRetorno = DB::select($sql);
      return $lstRetorno;
  }
}
?>