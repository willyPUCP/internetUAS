@extends('app')
@section('content')

<div class="page-title">
    <div class="title_left">
        <h3> {{ $course->Nombre }} </h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <form class="form-horizontal" novalidate="true" action="{{ route('saveMesuringByCourse.measurementSource')}}" method="POST" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="x_title">
                    <h2> Información del Curso </h2>
                    <div class="clearfix"></div>
                </div>

                <input id="courseId" name="courseId" type="text" name="code" readonly="true" value="{{$course->IdCurso}}" hidden="true">

                <div class="form-horizontal">
                    <div class="form-group row">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Código </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="code" class="form-control col-md-7 col-xs-12" type="text" name="code" readonly="true" value="{{$course->Codigo}}">
                        </div>
                    </div>
                </div>

                <div class="form-horizontal">
                    <div class="form-group row">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Nivel Académico </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="academicLevel" class="form-control col-md-7 col-xs-12" name="academicLevel" type="text" readonly="true" value="{{$course->NivelAcademico}}">
                        </div>
                    </div>
                </div>

                <div class="form-horizontal">
                    <div class="form-group row">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Especialidad </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="faculty" name="faculty" class="form-control col-md-7 col-xs-12" type="text" readonly="true" value="{{$course->faculty->Nombre}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    </br>
                    </br>
                    </div>
                </div>   

                <div class="x_title">
                    <h2>  Instrumentos de Medición Asociados </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="btn btn-success" data-toggle="modal" data-target="#modal-source">
                                <i class="fa fa-plus"></i> Agregar Instrumentos de Medición 
                            </div>
                        </div>    
                    </div>                
                </div>        
                </br> 


                <div class="form-horizontal">
                    <div class="form-group row">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Resultado Estudiantil</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="idStudentsResult" name="idStudentsResult" class="form-control col-md-7 col-xs-12" type="text">
                                <option value="">-- Seleccione --</option>
                                @if($studentsResults != null)
                                @foreach($studentsResults as $stdRslt)
                                <option value="{{ $stdRslt->Identificador }}">
                                    {{ $stdRslt->Identificador }} - {{ $stdRslt->Descripcion }}
                                </option> 
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

            <div class="form-group" id="detailTable">
<table class="table table-striped responsive-utilities jambo_table bulk_action" name="table-objs" border="2">
    <thead>
        <tr class="even pointer"> 
            <th class="column-title" style="vertical-align: middle"> Aspecto </th>
            <th class="column-title" style="vertical-align: middle"> Criterio </th>

            @if($sources!=null)
            @foreach($sources as $src)                             
                <th value="{{ $src->IdFuenteMedicion }}" class="{{$src->IdFuenteMedicion}}" style="vertical-align: middle">{{ $src->measurement->Nombre }} </th>    
            @endforeach
            @endif
        </tr>
    </thead>
    <tbody > 
        @if($studentsResults != null)
        @foreach($studentsResults as $stdRslt)

            @foreach($stdRslt->aspects as $aspt)
                @if($aspt->Estado == 1)
                    @foreach($aspt->criterion as $crt)
                        @if($crt->Estado == 1)
             <tr class="even pointer table-mxc" name="{{$stdRslt->Identificador}}" hidden="true"> 
                <td value="{{ $aspt->IdAspecto }}" style="vertical-align: middle">{{ $aspt->Nombre }} </td> 
                <td value="{{ $crt->IdCriterio }}" style="vertical-align: middle">{{ $crt->Nombre }} </td> 
                @if($sources!=null)
                @foreach($sources as $src) 
                    <?php $temp = ''; ?>
                    @if($msrxcrt!=null)
                    @foreach($msrxcrt as $mxc) 
                        @if($mxc->IdFuenteMedicion ==  $src->IdFuenteMedicion AND $mxc->IdCriterio ==  $crt->IdCriterio)
                            <?php $temp = "checked"; ?>    
                        @endif
                    @endforeach
                    @endif  
                    <td value="{{ $src->IdFuenteMedicion }}" class="{{$src->IdFuenteMedicion}}" style="vertical-align: middle">
                        <input value="{{$crt->IdCriterio}}-{{$src->IdFuenteMedicion}}" type="checkbox" class="checkFlat" id="stRstCheck" name="stRstCheck[]"  {{ $temp }}>
                    </td>   
                @endforeach
                @endif  
            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach

        @endforeach
        @endif
    </tbody>
</table> 

            </div>

            <div class="separator"></div>

            <div class="row">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <button class="btn btn-success pull-right" type="submit">Guardar</button>
                    <a href="{{ route('index.dictatedCourses') }}" class="btn btn-default pull-right">Cancelar</a>
                </div>
            </div>

            </form>


        </div>
    </div>
</div>
@include('measurementSource.modal-source')

<script src="{{ URL::asset('js/intranetjs/measurementSource/view-course-script.js')}}"></script>


@endsection