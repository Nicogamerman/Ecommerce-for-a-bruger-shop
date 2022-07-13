<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model{

      protected $table = 'categorias';
      public $timestamps = false;
  
      protected $fillable = [
          'idcategoria',
          'nombre'
          
      ];
  
      protected $hidden = [
  
      ];
  

    public function insertar(){
        $sql = "INSERT INTO $this->table (            
            nombre,
            
            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->nombre
        ]);
        return $this->idcategoria = DB::getPdo()->lastInsertId();
    }

}