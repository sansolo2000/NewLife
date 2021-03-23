@extends('admin.layouts.master')

@section('title', 'Editar tipo de acción jira')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{-- <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3"> --}}
            <a href="{{ url('admin/tipoaccionjira') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">

            @if (!$errors->any())
                @include('message.alert')
            @endif
            <div class="card card-body">
                <form action="{{ url('admin/tipoaccionjira/'.$TipoAccionJira->tiaj_id.'/edit' ) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="tiaj_nombre" class="form-control" value="{{ old('tiaj_nombre', $TipoAccionJira->tiaj_nombre) }}">
                                @include('message.controlerror', ['control' => 'tiaj_nombre'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de estado</label>
                                {{ Form::select('ties_nombre', $TipoEstado, old('ties_nombre', $TipoAccionJira->ties_id), $class_ties_nombre) }}
                                @include('message.controlerror', ['control' => 'ties_nombre'])
                            </div>                    
                        </div>                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Activo</label>
                                {{ Form::select('tiaj_activo', ['' => 'Seleccione una opción', 'S' => 'Sí', 'N' => 'No'], old('tiaj_activo', $TipoAccionJira->tiaj_activo), array('class' => 'custom-select')) }}
                                @include('message.controlerror', ['control' => 'tiaj_activo'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable actual</label>
                                {{ Form::select('tiaj_responsable_actual', ['' => 'Seleccione una opción', 'Interno' => 'Indra', 'Externo' => 'HLF'], old('tiaj_responsable_actual', $TipoAccionJira->tiaj_responsable_actual), array('class' => 'custom-select')) }}
                                @include('message.controlerror', ['control' => 'tiaj_responsable_actual'])
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable siguiente</label>
                                {{ Form::select('tiaj_responsable_siguiente', ['' => 'Seleccione una opción', 'Interno' => 'Indra', 'Externo' => 'HLF'], old('tiaj_responsable_siguiente', $TipoAccionJira->tiaj_responsable_siguiente), array('class' => 'custom-select')) }}
                                @include('message.controlerror', ['control' => 'tiaj_responsable_siguiente'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo de acción</label>
                                {{ Form::select('tiaj_tipo', ['' => 'Seleccione una opción', 'Jira' => 'Jira', 'Version' => 'Versión'], old('tiaj_tipo', $TipoAccionJira->tiaj_tipo), array('class' => 'custom-select')) }}
                                @include('message.controlerror', ['control' => 'tiaj_tipo'])
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" name="tiaj_codigo" class="form-control" value="{{ old('tiaj_codigo', $TipoAccionJira->tiaj_codigo)}}">
                                @include('message.controlerror', ['control' => 'tiaj_codigo'])
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Índice</label>
                                <input type="text" name="tiaj_indice" class="form-control" value="{{ old('tiaj_indice', $TipoAccionJira->tiaj_indice) }}">
                                @include('message.controlerror', ['control' => 'tiaj_indice'])
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Caracter del estado</label>
                                {{ Form::select('tiaj_estado', ['' => 'Seleccione una opción', 'Informativo' => 'Informativo', 'Pregunta' => 'Pregunta', 'Respuesta' => 'Respuesta'], old('tiaj_estado', $TipoAccionJira->tiaj_estado), array('class' => 'custom-select')) }}
                                @include('message.controlerror', ['control' => 'tiaj_estado'])
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sucesores</label>
                                {{ Form::select('tiaj_sucesores[]', $tiaj_indices, old('tiaj_sucesores[]', $tiaj_sucesor), $class_tiaj_sucesor) }}
                            </div>   
                        </div>   
                    </div>   
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection