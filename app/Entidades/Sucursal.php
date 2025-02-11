<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model{

      protected $table = 'sucursales';
      public $timestamps = false;
  
      protected $fillable = [
          'idsucursal',
          'nombre',
          'telefono',
          'direccion',
          'linkmapa'
      ];
  
      protected $hidden = [
  
      ];

      public function cargarDesdeRequest($request) { //recibe por variable request generado por laravel.
        $this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idcliente;
        $this->nombre = $request->input('txtNombre');
        $this->telefono = $request->input('txtTelefono');
        $this->direccion = $request->input('txtDireccion');
        $this->linkmapa = $request->input('txtLinkMapa');
    }

    /**
     * It inserts a new row into the database table, and returns the ID of the new row
     * 
     * @return The last inserted id.
     */
    public function insertar(){
        $sql = "INSERT INTO $this->table (    
            nombre,   
            telefono,
            direccion,
            linkmapa
            ) VALUES (?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->telefono,
            $this->direccion,
            $this->linkmapa         
        ]);
        return $this->idsucursal = DB::getPdo()->lastInsertId();
    }
 
   /**
    * It updates the table with the values of the object's properties
    */
    public function guardar() {
        $sql = "UPDATE $this->table SET
            idsucursal=$this->idsucursal,
            nombre='$this->nombre',
            telefono='$this->telefono',
            direccion='$this->direccion',
            linkmapa='$this->linkmapa'
            WHERE idsucursal=?";
        $affected = DB::update($sql, [$this->idsucursal]);
    }

   /**
    * It's a function that returns a single row from a table
    * 
    * @param idsucursal The ID of the record you want to retrieve.
    * 
    * @return The object itself.
    */
    public function obtenerPorId($idsucursal)
    {
        $sql = "SELECT
                idsucursal,
                nombre,
                telefono,
                direccion,
                linkmapa                   
                FROM sucursales WHERE idsucursal = $idsucursal";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->linkmapa = $lstRetorno[0]->linkmapa;                
            return $this;
        }
        return null;
    }

    /**
     * It deletes a row from the database table where the id of the row is equal to the id of the
     * object
     */
    public function eliminar(){
        $sql = "DELETE FROM $this->table WHERE idsucursal=?";
        $affected = DB::delete($sql, [$this->idsucursal]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idsucursal,
                  A.nombre,
                  A.telefono,
                  A.direccion,
                  A.linkmapa              
                FROM sucursales A ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
 
   /**
    * It's a function that returns a list of objects that are filtered by a search term.
    */
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idsucursal',
            1 => 'A.telefono',
            2 => 'A.direccion',
            3 => 'A.linkmapa',
            4 => 'A.nombre',
        );
        $sql = "SELECT DISTINCT
                    A.idsucursal,
                    A.telefono,
                    A.direccion,
                    A.linkmapa,
                    A.nombre
                    FROM sucursales A WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.telefono LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.direccion LIKE '%" . $request['search']['value'] . "%' ";       
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}