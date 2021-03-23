@extends('admin.layouts.master')

@section('title', 'Editar acción de versión')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url("admin/version/$versionaccion->vers_id") }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">
            <div class="col-md-6 offset-md-3">
                @include('message.alert')
                <div class="card card-body">
                    <form action="{{ url("admin/versionaccion/$versionaccion->vers_id/$versionaccion->veac_id/edit") }}" method="post" enctype="multipart/form-data">
                        @csrf 
                        <div class="form-group">
                            <label>Tipo de acción</label>
                            {{ Form::text('tiaj_nombre', $versionaccion->tiaj_nombre, array('class' => 'form-control', 'disabled' => 'disabled', 'id' => 'tiaj_nombre')) }}
                            {{ Form::hidden('tiaj_id', $versionaccion->tiaj_id) }}
                        </div>
                        <div class="form-group">
                            <label>Descripcion:</label>
                            {{ Form::text('veac_nombre', old('veac_nombre', $versionaccion->veac_nombre), array('class'=>'form-control','id'=>'veac_nombre')) }}
                        </div>
                        <div class="form-group">
                            <label>Detalle</label>
                            {{ Form::textarea('veac_observacion', old('veac_observacion', $versionaccion->veac_observacion), array('class'=>'form-control','id'=>'veac_observacion', 'rows' => 2)) }}
                        </div>
                        <div class="form-group">
                            <label>Fecha:</label>
                            <div class="input-group date">
                                {{ Form::text('veac_fecha', $versionaccion->veac_fecha_format(), array("id" => "veac_fecha", "class" => "form-control")) }}
                                {{ Form::hidden('vers_id', $versionaccion->vers_id) }}
                                <script>
                                    $('#veac_fecha').datepicker({
                                        uiLibrary: 'bootstrap4',
                                        format: 'dd-mm-yyyy'
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <label for="jiac_ruta">Evidencia:</label>
                                        </td>
                                        <td>
                                            <a href="{{ url("admin/versionaccion/$versionaccion->veac_id/download") }}" class="btn btn-info btn-sm {{ is_null($versionaccion->veac_ruta) ? 'disabled' : '' }}">
                                                <i class="fas {{ is_null($versionaccion->veac_ruta) ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    {{ Form::file('veac_ruta', array('clase' => 'custom-file-input', 'id' => 'veac_ruta')) }}
                                                    <label class="custom-file-label" for="veac_ruta">Seleccione</label>
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
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
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