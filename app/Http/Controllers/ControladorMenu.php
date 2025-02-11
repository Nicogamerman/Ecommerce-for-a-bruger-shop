<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Menu; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorMenu extends Controller
{
    public function index()
    {
        $titulo = "Menú";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('sistema.menu-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Menu();
        $aMenu = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aMenu) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/sistema/menu/' . $aMenu[$i]->idmenu . '">' . $aMenu[$i]->nombre . '</a>';
            $row[] = $aMenu[$i]->padre;
            $row[] = $aMenu[$i]->url;
            $row[] = $aMenu[$i]->activo;
            $cont++;
            $data[] = $row;
        }

       /* This is the response that the datatable is expecting. */
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aMenu), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aMenu), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function nuevo()
    {
        $titulo = "Nuevo Menú";
        $menu = new Menu();
        $array_menu = $menu->obtenerMenuPadre();
        return view('sistema.menu-nuevo', compact('menu', 'titulo', 'array_menu'));

    }
    
    public function editar($id)
    {
        $titulo = "Modificar Menú";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $menu = new Menu();
                $menu->obtenerPorId($id);

                $entidad = new Menu();
                $array_menu = $entidad->obtenerMenuPadre($id);

                $menu_grupo = new MenuArea();
                $array_menu_grupo = $menu_grupo->obtenerPorMenu($id);

                return view('sistema.menu-nuevo', compact('menu', 'titulo', 'array_menu', 'array_menu_grupo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("MENUELIMINAR")) {

                $menu_grupo = new MenuArea();
                $menu_grupo->fk_idmenu = $id;
                $menu_grupo->eliminarPorMenu();

                $entidad = new Menu();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //Deleted status ok!
            } else {
                $codigo = "ELIMINARPROFESIONAL";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }

   /* Loading the data from the request into the entity. */
    public function guardar(Request $request) {
        try {
            
            $titulo = "Modificar menú";
            $entidad = new Menu();
            $entidad->cargarDesdeRequest($request);
      
           /* Checking if the name is empty, if it is empty it will return an error message. If it is
           not empty it will check if the id is greater than 0, if it is greater than 0 it will
           update the data. */
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {                    
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {                    
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $menu_grupo = new MenuArea();
                $menu_grupo->fk_idmenu = $entidad->idmenu;
                $menu_grupo->eliminarPorMenu();
                if ($request->input("chk_grupo") != null && count($request->input("chk_grupo")) > 0) {
                    foreach ($request->input("chk_grupo") as $grupo_id) {
                        $menu_grupo->fk_idarea = $grupo_id;
                        $menu_grupo->insertar();
                    }
                }
                $_POST["id"] = $entidad->idmenu;
                return view('sistema.menu-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idmenu;
        $menu = new Menu();
        $menu->obtenerPorId($id);

        $entidad = new Menu();
        $array_menu = $entidad->obtenerMenuPadre($id);

        $menu_grupo = new MenuArea();
        $array_menu_grupo = $menu_grupo->obtenerPorMenu($id);

        return view('sistema.menu-nuevo', compact('msg', 'menu', 'titulo', 'array_menu', 'array_menu_grupo')) . '?id=' . $menu->idmenu;

    }
}
