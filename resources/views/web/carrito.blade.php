@extends('web.plantilla')
@section('contenido')
@section('scripts')
<script>
    globalId = '<?php echo isset($carrito_producto->idcarrito_producto) && $carrito_producto->idcarrito_producto > 0 ? $carrito_producto->idcarrito_producto : 0; ?>';
    <?php $globalId = isset($carrito_producto->idcarrito_producto) ? $carrito_producto->idcarrito_producto : "0";?>
</script>
@endsection
<section class="food_section layout_padding">
      
      <form action="" method="POST">            
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <div class="container">
                  <div class="heading_container heading_center">
                        <h2>Mi Carrito</h2>
                  </div>
                  @if(isset($msg))
                        <div class="alert alert-{{ $msg['estado'] }}" role="alert">{{$msg["mensaje"]}}</div>
                  @endif
                  <div class="row mt-4">
                                                
                        <table class="table table-striped table-hover border">
                              <thead>
                                    <tr>       
                                          <th class="lead">Imagen</th>                                 
                                          <th class="lead">Nombre</th>
                                          <th class="lead">Precio</th>
                                          <th class="lead">Cantidad</th>
                                          <th class="lead">Total item</th>                                   
                                          <th class="lead"></th>                                   
                                    </tr>
                              </thead>

                              <tbody>
                                    <?php $total = 0 ?>
                                    @foreach($aCarrito_productos as $item)
                                          <?php $subtotal= $item ->precioproducto * $item ->cantidad; ?>
                                                <tr>                                                      
                                                      <td><img src="/files/{{$item->imagenproducto}}" class = "img-responsive" width="150px" height="110px"></td> 
                                                      <td>{{$item->nombreproducto}}</td>
                                                      <td>${{$item->precioproducto}}</td>
                                                      <td>{{$item->cantidad}}</td>
                                                      <td>${{ number_format ($subtotal, 2, ",","." ) }}</td>
                                                      <td><a href="/carrito/eliminarProducto/{{$item->idcarrito_producto}}" type="button" class="btn btn-outline-danger shadow">Eliminar</a></td>                                                               
                                                </tr>
                                               
                                          <?php $total += $subtotal; ?>
                                    @endforeach
                              </tbody>                        
                        </table> 

                        <div class="col-12">
                              <label for="" class="d-block">Sucursal donde retirar el pedido:</label>
                              <select name="lstSucursal" id="lstSucursal" class="form-control">
                                    @foreach ($aSucursales as $sucursal)
                                          <option value="{{ $sucursal -> idsucursal }}">{{ $sucursal -> nombre}} </option>                        
                                    @endforeach
                              </select>
                        </div>

                        <div class="col-12">
                              <label for="" class="d-block">Selecciona el medio de pago:</label>
                              <select name="lstMedioDePago" id="lstMedioDePago" class="form-control">
                                    <option value="mercadopago">Mercadopago</option>
                                    <option value="sucursal" >Pago en sucursal</option>
                              </select>
                        </div>
                       
                        <div class="col-12 p-3">
                              <a href="/takeaway" class="btn btn-warning shadow ">Agregar más productos</a>
                              <div class="col-6 float-right lead">                              
                                    <div>
                                          <button type="submit" href="/mi-cuenta" class="btn btn-success shadow float-right">Finalizar pedido ${{$total}}</button>
                                    </div>                                                        
                              </div>    
                        </div> 
                        
                  </div>
      </form>
</section>
@endsection