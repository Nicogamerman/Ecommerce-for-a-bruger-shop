@extends('web.plantilla')
@section('contenido')

<!-- book section -->
<section class="book_section layout_padding">
      <div class="container">
            <div class="heading_container">
                  @if(isset($msg))
                  <div class="alert alert-{{ $msg['estado'] }}" role="alert">
                        {{$msg["msg"]}}
                  </div>
                  @endif
                  <div class="card border-light mb-3 col-6">
                        <div class="card-body">
                              <h2 class="card-title">{{ $cliente->nombre . " " . $cliente->apellido}}</h2>
                              <p class="card-text">Celular: {{ $cliente->celular}}</p>
                              <p class="card-text">Correo: {{ $cliente->correo}}</p>
                        </div>
                  </div>
                  <div class="form_container">
                        <div class="btn_box">
                              <a href="/cambiar-datos">Cambiar datos</a>
                        </div>
                        <div class="btn_box">
                              <a href="/cambiar-clave">Cambiar clave</a>
                        </div>
                  </div>
            </div>
      </div>
      <div class="pt-5">
            <div class="container">
                  <div class="heading_container">
                        <div class="card border-light mb-3 col-12">
                              <div class="card-body">
                                    <div>
                                          <h2 class="text-center p-4">Pedidos</h2>
                                          <table class="table table-striped table-hover border">
                                                <thead>
                                                      <tr>
                                                            <th>Pedido</th>
                                                            <th>Fecha</th>
                                                            <th>Descripción</th>
                                                            <th>Total</th>
                                                            <th>Sucursal</th>
                                                            <th>Cliente</th>
                                                            <th>Estado</th>
                                                      </tr>
                                                </thead>
                                          </table>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

</section>
<!-- end book section -->

@endsection