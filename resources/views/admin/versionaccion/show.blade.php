@extends('admin.layouts.master')

@section('title', 'Mostrar Acción Versión')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url("admin/version/$vers_id") }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if (!$errors->any())
                    @include('message.alert')
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-12">
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
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripcion:</label>
                                {{ Form::text('veac_nombre', $Version->veac_nombre, array('class'=>'form-control','id'=>'veac_nombre', 'disabled' => 'disabled')) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                {{ Form::textarea('veac_observacion', $Version->veac_observacion, array('class'=>'form-control','id'=>'veac_observacion', 'rows' => 2, 'disabled' => 'disabled')) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha:</label>
                                <div class="input-group date">
                                    {{ Form::text('veac_fecha', null, array("id" => "veac_fecha", "class" => "form-control", 'disabled' => 'disabled')) }}
                                    {{ Form::hidden('vers_id', $vers_id) }}
                                    <script>
                                        hoy = '{{ date("d-m-Y") }}';
                                        fecha = '{{ $Version->veac_fecha_format() }}';
                                        if (fecha == ''){
                                            mostrar = hoy;
                                        }
                                        else{
                                            mostrar = fecha;
                                        }
                                        $('#veac_fecha').datepicker({
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