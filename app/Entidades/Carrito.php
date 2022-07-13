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

    public function eliminar(){
        $sql = "DELETE FROM carritos WHERE
            idcarrito=?";
        $affected = DB::delete($sql, [$this->idcarrito]);
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


}