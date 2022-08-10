@extends('plantilla')

@section('titulo', $titulo)
 
@section('scripts')
<!-- asset lo busca dentro de la carpeta public cssdatatables, lo mismo para el asset de js-->
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet"> 
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Sucursales</a></li>
</ol>
<!-- Defino la toolbar -->
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/sucursal/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/sucursales");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th></th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Linkmapa</th>
            <th>Nombre</th>
        </tr>
    </thead>
</table> 
<script>
	$(document).ready( function () {
    var dataTable = $('#grilla').DataTable({
	    "processing": true,
        "serverSide": true,
	    "bFilter": true,
	    "bInfo": true,
	    "bSearchable": true,
        "pageLength": 25,
        "order": [[ 0, "asc" ]],
	    "ajax": "{{ route('sucursal.cargarGrilla') }}"
	});
} );
</script>
@endsection