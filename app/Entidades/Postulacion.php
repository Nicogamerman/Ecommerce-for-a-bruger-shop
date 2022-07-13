<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model{

      protected $table = 'postulaciones';
      public $timestamps = false;
  
      protected $fillable = [
          'idpostulacion',
          'nombre',
          'apellido',
          'celular',
          'correo',
          'curriculum'          
      ];
  
      protected $hidden = [
  
      ];
  

    public function insertar(){
        $sql = "INSERT INTO $this->table (
            idpostulacion,            
            nombre,
            apellido,
            correo,
            celular,
            curriculum,
           
            ) VALUES (?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idpostulacion,
            $this->nombre,
            $this->apellido,
            $this->correo,
            $this->dni,
            $this->celular, 
            $this->curriculum           
        ]);
        return $this->idpostulacion = DB::getPdo()->lastInsertId();
    }
    public function guardar() {
        $sql = "UPDATE $this->table SET
            idpostulacion=$this->idpostulacion,
            nombre='$this->nombre',
            apellido='$this->apellido',
            correo='$this->correo',
            dni='$this->dni'
            celular='$this->celular'
            curriculum='$this->curriculum'
            WHERE idpostulacion=?";
        $affected = DB::update($sql, [$this->idpostulacion]);
    }

    public function obtenerPorId($idpostulacion)
    {
        $sql = "SELECT
                idpostulacion,
                nombre,
                apellido,
                correo,
                dni,
                celular,  
                curriculum              
                FROM productos WHERE idproducto = $idpostulacion";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpostulacion = $lstRetorno[0]->idpostulacion;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->correo = $lstRetorno[0]->correo;
            $this->dni = $lstRetorno[0]->dni;  
            $this->celular = $lstRetorno[0]->celular;      
            $this->curriculum = $lstRetorno[0]->curriculum;            
            return $this;
        }
        return null;
    }

    public function eliminar(){
        $sql = "DELETE FROM $this->table WHERE
            idpostulacion=?";
        $affected = DB::delete($sql, [$this->idpostulacion]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idpostulacion,
                  A.nombre,
                  A.apellido,
                  A.correo,
                  A.dni,
                  A.celular,
                  A.curriculum              
                FROM postulaciones A ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}
    