@extends('admin.layouts.master')

@section('title', 'Crear Jira')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('admin/jira') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">
            @if (!$errors->any())
                @include('message.alert')
            @endif
            <div class="card card-body">
                <form action="{{ url('admin/jira') }}" method="post" enctype="multipart/form-data">
                @csrf 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" name="jira_codigo" value="{{ old('jira_codigo') }}" class="form-control">
                                @include('message.controlerror', ['control' => 'jira_codigo'])
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asunto</label>
                                <input type="text" name="jira_asunto" value="{{ old('jira_asunto') }}" class="form-control">
                                @include('message.controlerror', ['control' => 'jira_asunto'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                {{ Form::textarea('jira_descripcion', old('jira_descripcion'), ['class'=>'form-control','id'=>'jira_descripcion', 'rows'=>'3']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Responsable</label>
                                {{ Form::select('tire_id', $tipo_responsables, old('tire_id'), array('class' => 'custom-select')) }}
                                @include('message.controlerror', ['control' => 'tire_id'])
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Prioridad</label>
                                {{ Form::select('tipr_id', $tipo_prioridades, old('tipr_id'), array('class' => 'custom-select')) }}
                                @include('message.controlerror', ['control' => 'tipr_id'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Tipo de jira</label>
                                {{ Form::select('tiji_id', $tipo_jiras, old('tiji_id'), array('class' => 'custom-select')) }}
                                @include('message.controlerror', ['control' => 'tiji_id'])
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha</label>
                                <div class="input-group date">
                                    <input type="text" name="jira_fecha" id="jira_fecha" class="form-control">
                                    @include('message.controlerror', ['control' => 'jira_fecha'])
                                    <script>
                                        hoy = '{{ date("d-m-Y") }}';
                                        fecha = '{{ old('jira_fecha') }}';
                                        if (fecha == ''){
                                            mostrar = hoy;
                                        }
                                        else{
                                            mostrar = fecha;
                                        }
                                        console.log('hoy: '+hoy);
                                        console.log('fecha: '+fecha);
                                        $('#jira_fecha').datepicker({
                                            uiLibrary: 'bootstrap4',
                                            format: 'dd-mm-yyyy',
                                            value: hoy
                                        });
                                    </script>
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

@endsection