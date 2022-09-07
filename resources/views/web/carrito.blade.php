@extends('web.plantilla')
@section('contenido')

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
                  <div class="row">                        
                  <table class="table table-striped table-hover border">
                        <thead>
                              <tr>       
                                    <th class="lead">Imagen</th>                                 
                                    <th class="lead">Nombre</th>
                                    <th class="lead">Precio</th>
                                    <th class="lead">Cantidad</th>
                                    <th class="lead">Total item</th>                                   
                                    <th class="lead">Eliminar Producto</th>                                    
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
                                          
                                          <?php $total = 0 ?>
                                          @foreach ($aCarrito_productos as $idcarrito)
                                          <form action="" method="POST">
                                                <td>
                                                      <button type="submit" class="btn btn-danger" id="btnEliminar" name="btnEliminar" >Eliminar {{$item->idcarrito}}</button>
                                                      <button type="submit" class="btn btn-primary" id="btnEditar" name="btnEditar" >Editar{{$item->idcarrito}}</button>
                                                </td>
                                          @endforeach
                                          </form>
                                                                              
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
                              <option value="sucursal">Pago en sucursal</option>
                        </select>
                  </div>                  
                  <div class="col-6">
                        <a href="/takeaway" class="lead">Agregar más productos</a>
                  </div>  
                  <div class="col-6">
                        <div class="col-12 float-right lead">
                              <h3>TOTAL: ${{$total}}</h3>
                              <div>
                                    <button type="submit" href="/takeaway" class="btn btn-success ">Finalizar pedido</button>
                              </div>
                        </div>
                  </div>  
                  
            </div>
      </form>
</section>
@endsection