@extends('admin.layouts.master')

@section('title', 'Consultar Acción Jira')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url("admin/jira/$jira->jira_id") }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">

            @include('message.alert')

            <div class="card card-body">
                <form action="{{ url("admin/jiraaccion/$jiraaccion->jiac_id") }}" method="post" enctype="multipart/form-data">
                    @csrf 
                    <div class="form-group">
                        <label>Tipo de acción</label>
                        {{ Form::text('tiaj_nombre', $jiraaccion->tiaj_nombre, array('class' => 'form-control', 'disabled' => 'disabled', 'id' => 'tiaj_nombre')) }}
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        {{ Form::text('jiac_descripcion', $jiraaccion->jiac_descripcion, array('class'=>'form-control','id'=>'jiac_descripcion', 'disabled' => 'disabled')) }}
                    </div>
                    <div class="form-group">
                        <label>Detalle</label>
                        {{ Form::textarea('jiac_observacion', $jiraaccion->jiac_observacion, array('class'=>'form-control','id'=>'jiac_observacion', 'rows' => 2, 'disabled' => 'disabled')) }}
                    </div>
                    <div class="form-group">
                        <label>Fecha</label>
                        <div class="input-group date">
                            {{ Form::text('jiac_fecha', $jiraaccion->jiac_fecha_format(), array('id' => 'jiac_fecha', 'class' => 'form-control', 'disabled' => 'disabled')) }}
                            {{ Form::hidden('jira_id', $jira->jira_id) }}
                         </div>
                    </div>
                    <div class="form-group">
                        <label>Evidencia:</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <a href="{{ url("admin/jiraaccion/$jiraaccion->jiac_id/download") }}" class="btn btn-info btn-sm {{ is_null($jiraaccion->jiac_ruta) ? 'disabled' : '' }}">
                                    <i class="fas {{ is_null($jiraaccion->jiac_ruta) ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                </a>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection