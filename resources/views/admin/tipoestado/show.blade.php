@extends('admin.layouts.master')

@section('title')
{{ $tipoestado->ties_nombre }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <a href="{{ url('admin/tipoestado') }}" class="btn btn-secondary mb-3">
            Volver
        </a>
        <div class="card card-body">
            <p>Nombre: {{ $tipoestado->ties_nombre }}</p>
            <p>Indice: {{ $tipoestado->ties_indice }}</p>
            <p> Activo: 
                @if ($tipoestado->ties_activo == 1)
                    Sí
                @else
                    No
                @endif    
            </p>
        </div>
    </div>
</div>
@endsection