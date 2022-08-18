@extends('web.plantilla')
@section('contenido')
<?php
$pg = "contacto"; ?>
  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Deje aqui su mensaje
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
          <form method="POST" action="" enctype="multipart/form-data">
               <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
              <div>
                <input type="text" class="form-control" placeholder="Nombre y Apellido*" name="txtNombre" required />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Numero de telefono*" name="txtTelefono" required />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Correo electronico*" name="txtCorreo" required />
              </div>
              <label for="txtMensaje">Mensaje*:</label>
              <textarea name="txtMensaje" id="txtMensaje" cols="38" rows="18" class="form-control" placeholder="Escribe aquí tu mensaje" required></textarea>
              <div>
              </div>
              <div class="btn_box">
                <button id="btnEnviar" name="btnEnviar">
                  Enviar
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54493.81271399806!2d-64.25691136376996!3d-31.390332757686544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94329925921c9753%3A0x6708d2295f136c50!2zTWNEb25hbGQncyDigKIgQXYuIFJhZmFlbCBOw7rDsWV6!5e0!3m2!1ses-419!2sar!4v1660786495488!5m2!1ses-419!2sar" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

@endsection