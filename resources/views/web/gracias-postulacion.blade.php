@extends('web.plantilla')
@section('contenido')

  <!-- book section -->
  <section class="book_section layout_padding ">
    <div class="container offset-sm-3 " >
      <div class="heading_container">
        <h2 class="pb-4 text-white">
          ¡Gracias por enviarnos tus datos!
        </h2>
      </div>
      <div class="progress">
        <div class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
      </div>

      <div class="row">
        <div class="col-md-6 text-white">
          <p>¡Los estaremos analizando y te contactaremos!</p>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

@endsection