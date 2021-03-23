@extends('admin.layouts.master')

@section('title')
    {{ $jira->jira_codigo }}
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('admin/jira') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
            @include('message.alert')
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3 class="card-title">Detalle del jira - {{ $jira->jira_codigo }}</h3>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ url("admin/incidente/$jira->jira_id") }}" class="btn btn-block btn-primary btn-sm">
                                        <i class="fas fa-binoculars"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Asunto:</label>
                                        <input type="text" name="jira_asunto" value="{{ $jira->jira_asunto }}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descripción:</label>
                                        {{ Form::textarea('jira_descripcion', $jira->jira_descripcion, ['class'=>'form-control','id'=>'jira_descripcion', 'rows'=>'3', 'disabled' => 'disabled']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Responsable:</label>
                                        <input type="text" name="tire_nombre" value="{{ $jira->tire_nombre }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Prioridad:</label>
                                        <input type="text" name="tipr_nombre" value="{{ $jira->tipr_nombre }}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de jira:</label>
                                        <input type="text" name="tiji_nombre" value="{{ $jira->tiji_nombre }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha:</label>
                                        <input type="text" name="tipr_fecha" value="{{ $jira->jira_fecha_format() }}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Estado:</label>
                                        <input type="text" name="ties_nombre" value="{{ $jira->ties_nombre }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Versión:</label>
                                        <input type="text" name="vers_nombre" value="{{ $jira->vers_nombre }}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Usuario:</label>
                                        <input type="text" name="user_nombre" value="{{ $jira->user_nombre }}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>                            
                        </div>                            
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-11">
                                        <h3 class="card-title">Acciones realizadas</h3>
                                    </div>
                                    @can('create jiraaccion')
                                        <div class="col-md-1">
                                            <a href="{{ url("admin/jiraaccion/create/$jira->jira_id") }}" class="btn btn-warning {{ ($jira->tiaj_responsable_siguiente == $user->area && $crear) ? '' : 'disabled' }}">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="acciones_jira" class="table table-bordered table-hover text-xs">
                                        <thead>
                                            <tr>
                                                <th>Operación</th>
                                                <th>Descripción</th>
                                                <th>Fecha</th>
                                                <th>Usuario</th>
                                                <th>Evidencia</th>
                                                <th>Acciones</th>                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jiraacciones as $jiraaccion)
                                            <tr>
                                                <td width='10%'>{{ $jiraaccion->tiaj_nombre }}</td>
                                                <td width='20%'>{{ $jiraaccion->jiac_descripcion_limite() }}</td>
                                                <td width='15%'>{{ $jiraaccion->jiac_fecha_format() }} </td>
                                                <td width='15%'>{{ $jiraaccion->user_nombre }} </td>
                                                <td width='10%' style="text-align: center;">
                                                    <a href="{{ url("admin/jiraaccion/$jiraaccion->jiac_id/download") }}" class="btn btn-info btn-sm {{ is_null($jiraaccion->jiac_ruta) ? 'disabled' : '' }}">
                                                        <i class="fas {{ is_null($jiraaccion->jiac_ruta) ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                                    </a>
                                                </td>
                                                <td width='30%'>
                                                    <a href="{{ url("admin/jiraaccion/$jiraaccion->jiac_id") }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @can('edit jiraaccion')
                                                        <a href="{{ url("admin/jiraaccion/$jiraaccion->jiac_id/edit") }}" class="btn btn-success btn-sm {{ ($jiraaccion->tiaj_responsable_actual == $user->area) ? '' : 'disabled' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan 
                                                    @can('delete jiraaccion')
                                                        <a href="{{ url("admin/jiraaccion/$jiraaccion->jiac_id/delete") }}" class="btn btn-danger btn-sm {{ ($jiraaccion->tiaj_responsable_actual == $user->area) ? '' : 'disabled' }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    @endcan                                
                                                </td>
                                            </tr>
                                            @endforeach                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready( function () {
        var table = $('#acciones_jira').DataTable({
            "paging":       false,
            "ordering":     false,
            "searching":    false,
            "info":         false,
            language: {
                url: "{{ mix('i18n/es_es.json') }}"
            },
            columnDefs: [
            { orderable: false, targets: 5 },
            { type: 'date-euro', targets: 2 }
        ],
        });
    } );

  </script>
@endsection