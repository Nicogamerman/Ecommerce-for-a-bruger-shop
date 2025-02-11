@extends('plantilla')
@section('titulo',"$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
    <?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0";?>
</script>
@endsection
<!-- TOOLBAR  INICIO/MENU/MODIFICAR dentro de NUEVO PRODUCTO -->
@section('breadcrumb') 
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/productos">Productos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/productos";
}
</script>
@endsection
@section ('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
        <div id = "msg"></div>
        <?php
if (isset($msg)) {
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<form id="form1" method="POST" enctype="multipart/form-data">          
<div class="row">
    <div  class="form-group col-lg-6">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>

                <div>
                  <label>Nombre: *</label>
                        <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$producto->nombre}}"required>
                        <option selected="" disabled=""></option>                    
                </div>
                <div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                </div>
                <div>
                  <label>Cantidad: *</label>
                        <input type="numbre" id="txtCantidad" name="txtCantidad" class="form-control" value="{{$producto->cantidad}}"required>
                </div>
                <div>
                  <label>Descripcion: *</label>
                        <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="{{$producto->descripcion}}"required>
                </div>
                <div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div>
                  <label>Precio: *</label>
                        <input type="number" id="txtPrecio" name="txtPrecio" class="form-control" value="{{$producto->precio}}"required>
                </div>                  
                <label> Categoria:</label>
                    <select id="lstCategoria" name="lstCategoria" class="form-control " required>
                        <option  disabled selected>Seleccionar</option>
                        @foreach($aCategorias as $item )
                            @if($producto->fk_idcategoria == $item->idcategoria)
                                <option selected value="{{ $item->idcategoria}}">{{$item->nombre}}</option>
                            @else
                                <option value="{{ $item->idcategoria}}"> {{$item->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>    
                <div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div>
                    <label for="imagen">Imagen:</label>
                    <input type="file" name="archivo" id="archivo" class=" form-control-file" >
                    <p>Archivos admitidos: .jpg .jpeg .png</p>
                </div>               
            </div>
    </div>
</form>

<script>

    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('admin/producto/eliminar') }}",
            data: { id:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
                if (data.err = "0") {
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow("Error al eliminar", "success");
                }
            }
        });
    }

</script>
     
@endsection
