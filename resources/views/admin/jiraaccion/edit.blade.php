@extends('admin.layouts.master')

@section('title', 'Crear Acción Jira')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url("admin/jira/$jiraaccion->jira_id") }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (!$errors->any())
                @include('message.alert')
            @endif
            <div class="card card-body">
                <form action="{{ url("admin/jiraaccion/$jiraaccion->jiac_id/edit") }}" method="post" enctype="multipart/form-data">
                    @csrf 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo de acción</label>
                                {{ Form::text('tiaj_nombre', old('tiaj_nombre', $jiraaccion->tiaj_nombre), array('class' => 'form-control', 'disabled' => 'disabled', 'id' => 'tiaj_nombre')) }}
                                @include('message.controlerror', ['control' => 'tiaj_nombre'])
                                {{ Form::hidden('tiaj_id', $jiraaccion->tiaj_id) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                {{ Form::text('jiac_descripcion', old('jiac_descripcion', $jiraaccion->jiac_descripcion), array('class'=>'form-control','id'=>'jiac_descripcion')) }}
                                @include('message.controlerror', ['control' => 'jiac_descripcion'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                {{ Form::textarea('jiac_observacion', old('jiac_observacion', $jiraaccion->jiac_observacion), array('class'=>'form-control','id'=>'jiac_observacion', 'rows' => 2)) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha</label>
                                <div class="input-group date">
                                    {{ Form::text('jiac_fecha', null, array("id" => "jiac_fecha", "class" => "form-control")) }}
                                    @include('message.controlerror', ['control' => 'jiac_fecha'])
                                    {{ Form::hidden('jira_id', $jiraaccion->jira_id) }}
                                    <script>
                                        guarda = "{{ $jiraaccion->jiac_fecha_format() }}";
                                        fecha = "{{ old('jiac_fecha') }}";
                                        if (fecha == ''){
                                            mostrar = guarda;
                                        }
                                        else{
                                            mostrar = fecha;
                                        }                                        
                                        $('#jiac_fecha').datepicker({
                                            uiLibrary: 'bootstrap4',
                                            format: 'dd-mm-yyyy',
                                            value: mostrar
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <label for="jiac_ruta">Evidencia:</label>
                                        </td>
                                        <td>
                                            <a href="{{ url("admin/jiraaccion/$jiraaccion->jiac_id/download") }}" class="btn btn-info btn-sm {{ is_null($jiraaccion->jiac_ruta) ? 'disabled' : '' }}">
                                                <i class="fas {{ is_null($jiraaccion->jiac_ruta) ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    {{ Form::file('jiac_ruta', array('clase' => 'custom-file-input', 'id' => 'jiac_ruta')) }}
                                                    <label class="custom-file-label" for="jiac_ruta">Seleccione</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Subir</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>                    
                        </div>                    
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>
@endsection