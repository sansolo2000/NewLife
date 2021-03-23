@extends('layouts.app')

@section('title', 'Tipo de Estado')

@section('content')
    <div class="container-fluid">
        <!-- Create and Search (Start) -->
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/category/create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus-circle"></i> Create
                </a>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="input-group input-group">
                        <input type="text" name="search" class="form-control float-right" placeholder="Search">
            
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
                <table class="table">
                    <tr>
                        <td>Id</td>
                        <td>Nombre</td>
                        <td>Indice</td>
                        <td>Activo</td>
                        <td>Actions</td>
                    </tr>
                    @forelse ($tipo_estados as $tipo_estado)
                        <tr>
                            <td>{{ $tipo_estados->ties_id }}</td>
                            <td>{{ $tipo_estados->ties_nombre }}</td>
                            <td>{{ $tipo_estados->ties_indice }} </td>
                            <td>{{ $tipo_estados->ties_activo }} </td>
                            <td>
                                <a href="{{ url("admin/category/$tipo_estado->id") }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ url("admin/category/$tipo_estado->id/edit") }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ url("admin/category/$tipo_estado->id/delete") }}" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @empty 
                        <tr>
                            <td colspan="5">
                                <h3>{{ request('search') ?? '' }}, no se encuntra registrado</h3>
                            </td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
@endsection