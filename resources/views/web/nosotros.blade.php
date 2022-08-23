@extends("web.plantilla")
@section('contenido')
  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box animate__animated animate__backInUp">
            <img src="web/images/about-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Cordoba Burguer´s!
              </h2>
            </div>
            <p>
                Somos la primer hamburgueseria del corazon de Argentina, trabajamos con ingredientes de primera calidad 
                estamos en cada detalle, seleccionando cada ingrediente, buscando siempre la excelencia para garantizar
                el mejor sabor!
            </p>
            <a href="#seccion1" >¡Solicita más informacion acá!</a>            
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->
  
  <!-- client section -->

  <section class="client_section pt-5" id="seccion1">
    <div class="container">
      <div class="heading_container heading_center psudo_white_primary mb_45">
        <h2>
          Testimonio de Nuestros clientes
        </h2>
      </div>
      <div class="carousel-wrap row ">
        <div class="owl-carousel client_owl-carousel">
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                Excelente espacio para comer, patio muy amplio con excelente diseño, ideal para acompañar las mejores hamburguesas. Sin duda mi lugar favorito!
                </p>
                <h6>
                  Rocio Alvarez
                </h6>                
              </div>
              <div class="img-box">
                <img src="web/images/client1.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                ¡Me encanta! No es una simple hamburgueseria, es un espacio que te invita a quedarte para disfrutar, ni que hablar de las opciones para comer sobre todo el menu SIN TACC!
                </p>
                <h6>
                  Mike Liotto
                </h6>                
              </div>
              <div class="img-box">
                <img src="web/images/client2.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                Que decir... probe hamburguesas de todo el mundo, sin duda me quedo con las de Córdoba!
                </p>
                <h6>
                  Ivan Mongi
                </h6>                
              </div>
              <div class="img-box">
                <img src="web/images/ivan.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                Había gente haciendo fila afuera, recomiendo reservar algunos días antes.
                </p>
                <h6>
                  Rodrigo Gamerman
                </h6>                
              </div>
              <div class="img-box">
                <img src="web/images/rodrigo.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>          
        </div>
      </div>
    </div>
  </section>
  <!-- end client section -->

  <section class="book_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container text-center">
        <h2>
          ¡Trabaja con nosotros!
        </h2>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form_container">
            <form method="POST" action="" enctype="multipart/form-data">
               <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
              <div>
                <input type="text" class="form-control" placeholder="Nombre" name="txtNombre"/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Apellido" name="txtApellido"/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Numero de Whatsapp" name="txtTelefono" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Correo electronico" name="txtCorreo" />
              </div>
               <div>                
                <textarea name="txtMensaje" id="txtMensaje" class="form-control" placeholder="Mensaje"></textarea>
              </div>
              <div>
                <label for="archivo" class="d-block">Adjunta tu CV:</label>
                <input type="file" name="archivo" id="archivo">
              </div>
              <div class="btn_box text-center">
                <button type="submit">
                  Enviar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection