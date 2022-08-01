<?php

namespace App\Entidades; 

use DB;
use Illuminate\Database\Eloquent\Model;
 
class Pedido extends Model{
 
      protected $table = 'pedidos';
      public $timestamps = false;
  
      protected $fillable = [
          'idpedido',
          'fecha',
          'descripcion',
          'total',
          'fk_idsucursal',
          'fk_idcliente',
          'fk_idestado'          
      ];
  
      protected $hidden = [
  
      ];

      public function cargarDesdeRequest($request) { //recibe por variable request generado por laravel.
        $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
        $this->fecha = $request->input('txtDate');
        $this->descripcion = $request->input('txtDescripcion');
        $this->total = $request->input('txtTotal');        
        $this->fk_idsucursal = $request->input('lstSucursal');
        $this->fk_idcliente = $request->input('lstCliente');
        $this->fk_idestado = $request->input('lstEstado');
        }
  
    public function insertar(){
        $sql = "INSERT INTO $this->table (                       
            fecha,
            descripcion,
            total,  
            fk_idsucursal,
            fk_idcliente,
            fk_idestado            
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [            
            $this->fecha,
            $this->descripcion,
            $this->total, 
            $this->fk_idsucursal,
            $this->fk_idcliente,
            $this->fk_idestado             
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE $this->table SET
            fecha='$this->fecha',            
            descripcion=$this->descripcion,
            total=$this->total,            
            fk_idcategoria=$this->fk_idcategoria, 
            fk_idcliente=$this->fk_idcliente,
            fk_idestado=$this->fk_idestado
            WHERE idpedido=?";
        $affected = DB::update($sql, [$this->idpedido]);
    }

    public function obtenerPorId($idpedido){
        $sql = "SELECT
                idpedido,
                fecha,                
                total,
                descripcion,                fk_idsucursal,                
                fk_idcliente,
                fk_idestado                
                FROM pedidos WHERE idpedido = $idpedido";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {            
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->fecha = $lstRetorno[0]->fecha;            
            $this->total = $lstRetorno[0]->total;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;      
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;     
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;          
            return $this;
        }
        return null;
    } 

    public function eliminar(){
        $sql = "DELETE FROM $this->table WHERE idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                idpedido,                
                fecha,
                descripcion,
                total,
                fk_idsucursal,               
                fk_idestado,       
                fk_idcliente                                   
                FROM pedidos  ORDER BY idpedido";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}