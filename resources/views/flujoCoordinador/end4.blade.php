@extends('appWithoutHamburger')
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Continuar configuración</h3>
  </div>  
</div>

<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">

    <div class="x_title">
      <h2>Cuarta parte del Flujo terminada con exito</h2>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">
            
      <div class="row" style="margin-top: 10px;">
        <div class="form-group">
          <div class="col-md-12 col-sm-12"></div>
          <p>
            La cuarta parte del flujo de coordinador está por concluir, se agregaron los siguientes elementos:
          </p>
          <br>
          <p>- Horarios asignados a cada curso dictado en un ciclo</p>
          <p>- Matriz de aporte</p>
          <p>- Tipo de evidencia</p>
          <br>
          <p>Usted ha terminado satisfactoriamente la cuarta parte del flujo. </p>
          <br>
          <p>Si necesita agregar mas información, podra hacerlo desde las opciones del menú.</p>
          </p>
        </div>
      </div>        
      
    </div>

    <div class="row"></div>
      <div class="separator"></div>
      <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
               <a  href="{{ route('index.subindex') }}" class="btn btn-success pull-right">Finalizar</a>
               <!--<a  href="#"  class="btn btn-default pull-left">< Atras</a>-->
          </div>
      </div>

    <br>

  </div>
</div>
@endsection