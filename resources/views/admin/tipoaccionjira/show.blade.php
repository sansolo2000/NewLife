@extends('admin.layouts.master')

@section('title', 'Mostrar tipo de acción jira')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('admin/tipoaccionjira') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">

            @if (!$errors->any())
                @include('message.alert')
            @endif
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="tiaj_nombre" class="form-control" disabled="disabled" value="{{ $TipoAccionJira->tiaj_nombre }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipo de estado</label>
                            {{ Form::text('ties_nombre',  $TipoAccionJira->ties_nombre, array('class' => 'custom-select', 'disabled' => 'disabled')) }}
                        </div>                    
                    </div>                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Activo</label>
                            {{ Form::text('tiaj_activo',  $TipoAccionJira->tiaj_activo, array('class' => 'custom-select', 'disabled' => 'disabled')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Responsable actual</label>
                            {{ Form::text('tiaj_responsable_actual', $TipoAccionJira->tiaj_responsable_actual, array('class' => 'custom-select', 'disabled' => 'disabled')) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Responsable siguiente</label>
                            {{ Form::text('tiaj_responsable_siguiente', $TipoAccionJira->tiaj_responsable_siguiente, array('class' => 'custom-select', 'disabled' => 'disabled')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tipo de acción</label>
                            {{ Form::text('tiaj_tipo', $TipoAccionJira->tiaj_tipo, array('class' => 'custom-select', 'disabled' => 'disabled')) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Codigo</label>
                            <input type="text" name="tiaj_codigo" class="form-control" disabled='disabled' value="{{ $TipoAccionJira->tiaj_codigo }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Índice</label>
                            <input type="text" name="tiaj_indice" class="form-control" value="{{ $TipoAccionJira->tiaj_indice }}" disabled='disabled'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Caracter del estado</label>
                            {{ Form::text('tiaj_estado', $TipoAccionJira->tiaj_estado, array('class' => 'custom-select', 'disabled' => 'disabled')) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sucesores</label>
                            {{ Form::select('tiaj_sucesores[]', $tiaj_indices, $tiaj_sucesor, $class_tiaj_sucesor) }}
                        </div>   
                    </div>   
                </div>   
            </div>
        </div>
    </div>
</div>

@endsection