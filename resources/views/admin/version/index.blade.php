@extends('admin.layouts.master')

@section('title', 'Versiones')

@section('content')
    <div class="container-fluid">
        <!-- Create and Search (Start) -->
        <div class="row">
            <div class="col-md-12">
                @include('message.alert')
            </div>
            @can('create version')
            <div class="col-md-6">
                <a href="{{ url('admin/version/create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus-circle"></i> Nuevo
                </a>
            </div>
            @endcan            
        </div>
        <!-- Create and Search (End) -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-body">
                        <table id="version_table" class="table table-striped dataTable text-xs" role="grid">
                            <thead>
                                <tr>
                                    <th width="12%">Id</th>
                                    <th width="13%">Nombre de versión</th>
                                    <th width="12%">Fecha de creación</th>
                                    <th width="12%">Estado</th>
                                    <th width="13%">Usuario</th>
                                    <th width="13%">Tipos de jiras</th>
                                    <th width="10%">Cantidad de Jiras</th>
                                    <th width="15%">Acciones</th>
                                </tr>
                            </thead>                        
                            <tbody>
                            @foreach ($Versiones as $Version)
                                <tr>
                                    <td>{{ $Version['vers_id'] }}</td>
                                    <td>{{ $Version['vers_nombre'] }}</td>
                                    <td>{{ $Version['vers_fecha_creacion'] }}</td>
                                    <td>{{ $Version['tiaj_nombre'] }}</td>
                                    <td>{{ $Version['user_nombre'] }}</td>
                                    <td><ul>{!! $Version['tipos_jiras'] !!}</ul></td>
                                    <td>{{ $Version['cant_jiras'] }}</td>
                                    <td>
                                        <a href="{{ url("admin/version/".$Version['vers_id']) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('edit version')
                                        <a href="{{ url("admin/version/".$Version['vers_id']."/edit") }}" class="btn btn-success btn-sm {{ ($Version['vers_id'] == 1) ? 'disabled' : '' }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan 
                                        @can('delete version')
                                        <a href="{{ url("admin/version/".$Version['vers_id']."/delete") }}" class="btn btn-danger btn-sm {{ ($Version['vers_id'] == 1) ? 'disabled' : '' }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @endcan                                                           
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre de versión</th>
                                    <th>Fecha de creación</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    <th>Tipos de jiras</th>
                                    <th>Cantidad de Jiras</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>                          
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            var table = $('#version_table').DataTable({
                language: {
                    url: "{{ mix('i18n/es_es.json') }}"
                },
                columnDefs: [
                { orderable: false, targets: 5 },
                { type: 'date-euro', targets: 3 }
            ],
            });
        } );
      </script>
@endsection