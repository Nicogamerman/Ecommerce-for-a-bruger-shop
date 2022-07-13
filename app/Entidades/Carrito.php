<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model{

      protected $table = 'carritos';
      public $timestamps = false;
  
      protected $fillable = [
          'idcarrito',
          'fk_idcliente'
      ];
  
      protected $hidden = [
  
      ];

    public function guardar() {
        $sql = "UPDATE sistema_menues SET
            nombre='$this->nombre',
            id_padre='$this->id_padre',
            orden=$this->orden,
            activo='$this->activo',
            url='$this->url',
            css='$this->css'
            WHERE idmenu=?";
        $affected = DB::update($sql, [$this->idmenu]);
    }
}