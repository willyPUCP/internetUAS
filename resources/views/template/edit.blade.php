@extends('app')
@section('content')
<div class="page-title">
	<div class="title_left">
		<h3>Editar Documento</h3>
	</div>
</div>
<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Informacion del Documento</h2>
                    <div class="clearfix"></div>
                </div>
                <form  class="form-horizontal" id="formUser" novalidate="true">
                <!--<form action="{{ route('supervisor.store') }}" method="POST" class="form-horizontal" id="formUser" novalidate="true">-->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="x_content">
                    	<div class="form-group">
							<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Fase* <span class="error">* </span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="hall" id="hall" value="3">
                                  <option selected="true">1</option>
                                  <option >2</option>
                                </select>                                
							</div>
						</div>
                        <div class="form-group">
                            <input type="text" id="validateCode" name="validateCode" hidden>
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Titulo* <span class="error">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="Ficha de Inscripcion" id="userfirstname" class="form-control col-md-7 col-xs-12" type="text" name="userfirstname" maxlength="20" required="required" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Buscar Archivo <span class="error">*</span></label>
                            <input type='file' name='userFile'>
                        </div>

                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Obligatorio* <span class="error">*</span></label>
                            <div class="col-md-1 col-sm-1 col-xs-12">
                                <input id="userspanishlastname" class="form-control col-md-7 col-xs-12" type="checkbox" checked="true" name="userspanishlastname"
                                       maxlength="20" required="required" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>     

                        <div class="clearfix"></div>
                        <div class="separator"></div>
                        <div class="row">
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <button class="btn btn-success pull-right" name="btnSave" type="submit">Guardar</button>
                                <a href="{{ route('index.templates') }}" class="btn btn-default pull-right"> Cancelar</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection