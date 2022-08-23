@extends('web.plantilla')
@section('contenido')

<section class="food_section layout_padding">
      <div class="container">
            <div class="heading_container heading_center">
                  <h2>Mi Carrito</h2>
            </div>
            @if(isset($msg))
                  <div class="alert alert-{{ $msg['estado'] }}" role="alert">{{$msg["mensaje"]}}</div>
            @endif
            <table class="table table-striped table-hover border">
                  <thead>
                        <tr>
                              <th>Cantidad</th>
                              <th>Imagen</th>
                              <th>Nombre</th>
                              <th>Precio</th>
                              <th>Boton eliminar</th>
                        </tr>
                  </thead>
            </table>
      </div>
</section>
@endsection