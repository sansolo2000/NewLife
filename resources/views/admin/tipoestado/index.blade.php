@extends('admin.layouts.master')

@section('title', 'Todos loa tipo de Estado')

@section('content')
    <div class="container-fluid">
        <!-- Create and Search (Start) -->
        <div class="row">
            <div class="col-md-12">
                @include('message.alert')
            </div>
            @can('create tipoestado')
            <div class="col-md-6">
                <a href="{{ url('admin/tipoestado/create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus-circle"></i> Nuevo
                </a>
            </div>
            @endcan            
            <div class="col-md-6">
                <form>
                    <div class="input-group input-group">
                        <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control float-right" placeholder="Buscar">
                                                <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Create and Search (End) -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body p-0">
                    <table class="table">
                        <tr>
                            <td>Id</td>
                            <td>Nombre</td>
                            <td>Indice</td>
                            <td>Activo</td>
                            <td>Acciones</td>
                        </tr>
                        @forelse ($tipoestados as $tipoestado)
                            <tr>
                                <td>{{ $tipoestado->ties_id }}</td>
                                <td>{{ $tipoestado->ties_nombre }}</td>
                                <td>{{ $tipoestado->ties_indice }} </td>
                                <td>
                                    @if ($tipoestado->ties_activo == 1)
                                        Sí
                                    @else
                                        No
                                    @endif    
                                </td>
                                <td>
                                    <a href="{{ url("admin/tipoestado/$tipoestado->ties_id") }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('edit tipoestado')
                                    <a href="{{ url("admin/tipoestado/$tipoestado->ties_id/edit") }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan 
                                    @can('delete tipoestado')
                                    <a href="{{ url("admin/tipoestado/$tipoestado->ties_id/delete") }}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @endcan                                
                                </td>
                            </tr>
                        @empty 
                            <tr>
                                <td colspan="5">
                                    <h3>"{{ request('search').'", no se encontró' ?? 'No hay registro' }}</h3>
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection