@extends('app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Editar Reunion</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="clearfix"></div>
                </div>
                {{Form::open(['route' => ['meeting.update',$meeting->id],'class' => ' form-horizontal','id'=>'formSuggestion'])}}
                    

                <div class="form-group">
                    {{Form::label('Tipo de reunion',null,['class'=>'control-label col-md-4 col-sm-3 col-xs-12'])}}
                    <div class="col-md-4">
                        @if($meeting->tiporeunion==1)
                        {{Form::text('tiporeunion','Supervisor-alumno',['class'=>'form-control', 'required','readonly'])}}    
                        @else
                        {{Form::text('tiporeunion','Jefe-alumno',['class'=>'form-control', 'required','readonly'])}}    
                        @endif
                    </div>                    
                </div>
                <div class="form-group">
                    {{Form::label('Fecha',null,['class'=>'control-label col-md-4 col-sm-3 col-xs-12'])}}
                    <div class="col-md-4">
                        {{Form::date('fecha', $meeting->fecha,['class'=>'form-control','readonly'])}}
                    </div>
                </div>

                <div class="form-group">
                    {{Form::label('Hora inicio',null,['class'=>'control-label col-md-4 col-sm-3 col-xs-12'])}}
                    <div class="col-md-4">
                        {{Form::time('hora_inicio',$meeting->hora_inicio,['class'=>'form-control', 'required','readonly'])}}    
                    </div>                    
                </div>

                <div class="form-group">
                    {{Form::label('Hora fin',null,['class'=>'control-label col-md-4 col-sm-3 col-xs-12'])}}
                    <div class="col-md-4">
                        {{Form::time('hora_fin',$meeting->hora_fin,['class'=>'form-control', 'required','readonly'])}}    
                    </div>                    
                </div>

                <div class="form-group">
                    {{Form::label('Codigo',null,['class'=>'control-label col-md-4 col-sm-3 col-xs-12'])}}
                    <div class="col-md-4">
                        {{Form::text('codigo',$meeting->student->Codigo,['class'=>'form-control', 'required','readonly'])}}    
                    </div>                    
                </div>

                <div class="form-group">
                    {{Form::label('Nombre',null,['class'=>'control-label col-md-4 col-sm-3 col-xs-12'])}}
                    <div class="col-md-4">
                        {{Form::text('nombre',$meeting->student->Nombre.' '.$meeting->student->ApellidoPaterno.' '.$meeting->student->ApellidoMaterno,['class'=>'form-control', 'required','readonly'])}}    
                    </div>                    
                </div>
                
                <div class="form-group">
                    {{Form::label('Lugar',null,['class'=>'control-label col-md-4 col-sm-3 col-xs-12'])}}
                    <div class="col-md-4">
                        {{Form::text('observaciones',$meeting->luger,['class'=>'form-control', 'required'])}}    
                    </div>                    
                </div>

                <div class="form-group">
                    {{Form::label('Observaciones',null,['class'=>'control-label col-md-4 col-sm-3 col-xs-12'])}}
                    <div class="col-md-4">
                        {{Form::text('observaciones',$meeting->observaciones,['class'=>'form-control', 'required'])}}    
                    </div>                    
                </div>

                <div class="form-group">
                    {{Form::label('Retroalimentacion',null,['class'=>'control-label col-md-4 col-sm-3 col-xs-12'])}}
                    <div class="col-md-4">
                        {{Form::text('observaciones',$meeting->retroalimentacion,['class'=>'form-control', 'required'])}}    
                    </div>                    
                </div>

                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        {{--Form::submit('Guardar', ['class'=>'btn btn-success pull-right'])--}}
                        <a class="btn btn-default pull-right" href="{{route('student.index')}}">Cancelar</a>
                    </div>
                </div>

                {{Form::close()}}

            </div>
        </div>
    </div>

@endsection