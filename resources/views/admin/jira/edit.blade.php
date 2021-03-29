@extends('admin.layouts.master')

@section('title', 'Editar Jira')

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
                @include('message.alert')
                <div class="card card-body">
                    <form action="{{ url("admin/jira/$jira->jira_id/edit") }}" method="post">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    {{ Form::text('jira_codigo_disable', $jira->jira_codigo, array('class' => 'form-control', 'disabled' => 'disabled')) }}
                                    {{ Form::hidden('jira_codigo', $jira->jira_codigo) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Asunto</label>
                                    {{ Form::text('jira_asunto', old('jira_asunto', $jira->jira_asunto), array('class' => 'form-control')) }}
                                    @include('message.controlerror', ['control' => 'jira_asunto'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Descripción</label>
                                    {{ Form::textarea('jira_descripcion', old('jira_descripcion', $jira->jira_descripcion), ['class'=>'form-control','id'=>'jira_descripcion', 'rows'=>'3']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Responsable</label>
                                    {{ Form::select('tire_id', $tipo_responsables, old('tire_id', $jira->tire_id), array('class' => 'custom-select')) }}
                                    @include('message.controlerror', ['control' => 'tire_id'])
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Prioridad</label>
                                    {{ Form::select('tipr_id', $tipo_prioridades, old('tipr_id', $jira->tipr_id), array('class' => 'custom-select')) }}
                                    @include('message.controlerror', ['control' => 'tipr_id'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Tipo de jira</label>
                                    {{ Form::select('tiji_id', $tipo_jiras, old('tiji_id', $jira->tiji_id), array('class' => 'custom-select')) }}
                                    @include('message.controlerror', ['control' => 'tiji_id'])
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <div class="input-group date">
                                        {{ Form::text('jira_fecha', old('jira_fecha', $jira->jira_fecha_format()), ['class' => 'form-control', 'id' => 'jira_fecha']) }}
                                        @include('message.controlerror', ['control' => 'jira_fecha'])
                                        <script>
                                            $('#jira_fecha').datepicker({
                                                uiLibrary: 'bootstrap4',
                                                format: 'dd-mm-yyyy'
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection