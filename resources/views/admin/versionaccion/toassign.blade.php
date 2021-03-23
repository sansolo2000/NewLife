@extends('admin.layouts.master')

@section('title', 'Asignar jiras a versión evolutiva')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url("admin/version/$version->vers_id") }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>

            @include('message.alert')

            <div class="card card-body">
                <form action="{{ url("admin/versionaccion/$version->vers_id/toassign") }}" method="post">
                    @csrf 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre de versión</label>
                                {{ Form::hidden('vers_id', $vers_id) }}
                                <input type="text" name="vers_nombre" value="{{ $version->vers_nombre }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Fecha</label>
                                <div class="input-group date">
                                    {{ Form::text('veac_fecha', null, $class_fecha) }}
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Seleccionar </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                @php
                                    echo $columna1;
                                @endphp
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @php
                                    echo $columna2;
                                @endphp
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @php
                                    echo $columna3;
                                @endphp
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @php
                                    echo $columna4;
                                @endphp
                            </div>
                        </div>
                    </div>
                    @if ($disabled == '')
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@endsection