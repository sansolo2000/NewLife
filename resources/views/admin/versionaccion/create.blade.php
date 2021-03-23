@extends('admin.layouts.master')

@section('title', 'Crear Acción Versión')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url("admin/version/$vers_id") }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">
            <div class="col-md-6 offset-md-3">

                @include('message.alert')

                <div class="card card-body">
                    <form action="{{ url("admin/versionaccion/$vers_id") }}" method="post" enctype="multipart/form-data">
                        @csrf 
                        <div class="form-group">
                            <label>Tipo de acción</label>
                            {{ Form::select('tiaj_nombre', $tipo_accion_jira, $tiaj_id, $class) }}
                            {{ Form::hidden('tiaj_id', $tiaj_id, array('id' => 'tiaj_id')) }}
                            <script>
                                $("#tiaj_nombre").change(function(event){
                                    document.getElementById("tiaj_id").value = this.value;
                                    console.log('hola');
                                })
                            </script>
                        </div> 
                        <div class="form-group">
                            <label>Descripcion:</label>
                            {{ Form::text('veac_nombre', old('veac_nombre'), array('class'=>'form-control','id'=>'veac_nombre')) }}
                        </div>
                        <div class="form-group">
                            <label>Detalle</label>
                            {{ Form::textarea('veac_observacion', old('veac_observacion'), array('class'=>'form-control','id'=>'veac_observacion', 'rows' => 2)) }}
                        </div>
                        <div class="form-group">
                            <label>Fecha:</label>
                            <div class="input-group date">
                                {{ Form::text('veac_fecha', null, array("id" => "veac_fecha", "class" => "form-control")) }}
                                {{ Form::hidden('vers_id', $vers_id) }}
                                <script>
                                    hoy = '{{ date("d-m-Y") }}';
                                    fecha = '{{ old('veac_fecha') }}';
                                    if (fecha == ''){
                                        mostrar = hoy;
                                    }
                                    else{
                                        mostrar = fecha;
                                    }
                                    console.log('hoy: '+hoy);
                                    console.log('fecha: '+fecha);
                                    $('#veac_fecha').datepicker({
                                        uiLibrary: 'bootstrap4',
                                        format: 'dd-mm-yyyy',
                                        value: hoy
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jiac_ruta">Evidencia:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    {{ Form::file('jiac_ruta', array('clase' => 'custom-file-input', 'id' => 'jiac_ruta')) }}
                                    <label class="custom-file-label" for="jiac_ruta">Seleccione</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Subir</span>
                                </div>
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Crear</button>
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