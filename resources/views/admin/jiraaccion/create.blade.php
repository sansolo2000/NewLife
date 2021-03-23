@extends('admin.layouts.master')

@section('title', 'Crear Acción Jira')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url("admin/jira/$jira_id") }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">
            @if (!$errors->any())
                @include('message.alert')
            @endif
            <div class="card card-body">
                <form action="{{ url("admin/jiraaccion/$jira_id") }}" method="post" enctype="multipart/form-data">
                    @csrf 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo de acción</label>
                                {{ Form::select('tiaj_nombre', $tipo_accion_jira, $tiaj_id, $class) }}
                                {{ Form::hidden('tiaj_id', $tiaj_id, array('id' => 'tiaj_id')) }}
                                @include('message.controlerror', ['control' => 'tiaj_id'])
                                <script>
                                    $("#tiaj_nombre").change(function(event){
                                        document.getElementById("tiaj_id").value = this.value;
                                        console.log('hola');
                                    })
                                </script>
                            </div>                        
                        </div>                        
                    </div>                        
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                {{ Form::text('jiac_descripcion', old('jiac_descripcion'), array('class'=>'form-control','id'=>'jiac_descripcion')) }}
                                @include('message.controlerror', ['control' => 'jiac_descripcion'])
                            </div>
                        </div>                        
                    </div>                        
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                {{ Form::textarea('jiac_observacion', old('jiac_observacion'), array('class'=>'form-control','id'=>'jiac_observacion', 'rows' => 3)) }}
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
                                    {{ Form::hidden('jira_id', $jira_id) }}
                                    <script>
                                        hoy = '{{ date("d-m-Y") }}';
                                        fecha = '{{ old('jiac_fecha') }}';
                                        if (fecha == ''){
                                            mostrar = hoy;
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
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
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