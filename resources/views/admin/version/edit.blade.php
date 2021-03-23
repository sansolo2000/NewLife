@extends('admin.layouts.master')

@section('title', 'Editar Versión')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('admin/version') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        @if (!$errors->any())
            @include('message.alert')
        @endif
            <div class="card card-body">

                <form action="{{ url("admin/version/$version->vers_id/edit") }}" method="post">
                    @csrf 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre de versión</label>
                                <input type="text" name="vers_nombre" value="{{ old('vers_nombre', $version->vers_nombre) }}" class="form-control">
                                @include('message.controlerror', ['control' => 'vers_nombre'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción de la versión</label>
                                <input type="text" name="veac_observacion" value="{{ old('veac_observacion') }}" class="form-control">
                                @include('message.controlerror', ['control' => 'veac_observacion'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Fecha</label>
                                {{ Form::text('jira_asunto', $version->vers_fecha_creacion_format(), array('class' => 'form-control', 'disabled' => 'disabled')) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo versión</label>
                                @foreach ($TiposJiras as $key => $TipoJira)
                                    <div class="checkbox">
                                        <label>
                                            <input  name="tiji[]" type="checkbox" value="{{ $key+1 }}" {{ $TipoVersionNew[$key+1] }}>
                                            {{ $TipoJira->tiji_nombre }}
                                        </label>
                                    </div>
                                @endforeach
                                @include('message.controlerror', ['control' => 'tiji'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estado Actual</label>
                                {{ Form::text('tiaj_nombre', $version->tiaj_nombre, ['class'=>'form-control','id'=>'tiaj_nombre', 'disabled' => 'disabled']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Usuario:</label>
                                <input type="text" name="user_nombre" value="{{ $version->user_nombre }}" class="form-control" disabled>
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