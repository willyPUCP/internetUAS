@extends('app')
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>{{$evaluation->nombre}} (pendientes)</h3>
    </div>    
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">                            
            <div class="table-responsive">
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <col width="20%" >
                    <col width="80%">
                    <col width="10%">
                    <thead>
                        <tr class="headings">                            
                            <th class="column-title">Código de evaluación </th>
                            <th class="column-title">Fecha de registro </th>                            
                            <th class="column-title last">Acciones</th>                                
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tutstudentxevaluations as $tutstudentxevaluation)
                        @if(! in_array($tutstudentxevaluation->id,  $arr_no_include ))
                        <tr class="even pointer">                                                   
                            <td class=" ">{{$tutstudentxevaluation->id }}</td>
                            <td class=" ">{{ date("d/m/Y g:i a", strtotime($tutstudentxevaluation->fecha_hora))}}</td>                                                                                    
                            <td class="">                                
                                <a href="{{route('evaluacion.corregir',[$tutstudentxevaluation->id_tutstudent,$tutstudentxevaluation->id_evaluation])}}" title="Corregir" class="btn btn-primary btn-xs view-group"">
                                    <i class="fa fa-pencil"></i>
                                </a>                               
                            </td>
                        </tr>   
                        @endif                     
                        @endforeach
                    </tbody>
                </table>                
            </div>             
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <a class="btn btn-default pull-left" href="{{ route('evaluacion_evaluador.index') }}">Regresar</a>
            </div>
                
            </div>
        </div>
    </div>
</div>
@endsection