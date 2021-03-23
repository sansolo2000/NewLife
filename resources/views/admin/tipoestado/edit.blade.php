@extends('admin.layouts.master')

@section('title', 'Modificación de Tipo de Estado')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{-- <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3"> --}}
            <a href="{{ url('admin/tipoestado') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">

            @include('message.alert')

            <div class="card card-body">
                <form action="{{ url("admin/tipoestado/$tipoestado->ties_id/edit") }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nombre del estado</label>
                        <input type="text" name="ties_nombre" value="{{ $tipoestado->ties_nombre }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Indice</label>
                        <input type="text" name="ties_indice" value="{{ $tipoestado->ties_indice }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Activo</label>
                        {{ Form::select('ties_activo', ['' => 'Seleccione una opción', 'S' => 'Sí', 'N' => 'No'], ($tipoestado->ties_activo) ? 'S': 'N', array('class' => 'custom-selectcustom-select')) }}
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection