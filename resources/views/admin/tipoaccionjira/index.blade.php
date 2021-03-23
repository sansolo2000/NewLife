@extends('admin.layouts.master')

@section('title', 'Tipos Acciones para los Jiras')

@section('content')
    <div class="container-fluid">
        <!-- Create and Search (Start) -->
        <div class="row">
            <div class="col-md-12">
                @include('message.alert')
            </div>
            @can('create tipoaccionjira')
            <div class="col-md-6">
                <a href="{{ url('admin/tipoaccionjira/create') }}" class="btn btn-primary mb-3">
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
                        <table id="jira_table" class="table table-striped dataTable text-xs display nowrap role="grid" width="100%">
                            <thead>
                                <tr>
                                    <th>Tipo de</th>
                                    <th rowspan="2">Nombre</th>
                                    <th rowspan="2">Activo</th>
                                    <th rowspan="2">Indice</th>
                                    <th colspan="2">Responsable</th>
                                    <th>Tipo de</th>
                                    <th rowspan="2">Sucesores</th>
                                    <th>Caracter del</th>
                                    <th>Código</th>
                                    <th rowspan="2">Acciones</th>
                                </tr>
                                <tr>
                                    <th>estado</th>
                                    <th>actual</th>
                                    <th>siguiente</th>
                                    <th>acción</th>
                                    <th>estado</th>
                                    <th>interno</th>
                                </tr>
                        </thead>                        
                            <tbody>
                                @foreach ($TiposAccionesJiras as $TipoAccionJira)
                                <tr>
                                    <td>{{ $TipoAccionJira['ties_nombre'] }}</td>
                                    <td>{{ $TipoAccionJira['tiaj_nombre'] }}</td>
                                    <td>{{ $TipoAccionJira['tiaj_activo'] }}</td>
                                    <td>{{ $TipoAccionJira['tiaj_indice'] }}</td>
                                    <td>{{ $TipoAccionJira['tiaj_responsable_actual'] }}</td>
                                    <td>{{ $TipoAccionJira['tiaj_responsable_siguiente'] }}</td>
                                    <td>{{ $TipoAccionJira['tiaj_tipo'] }}</td>
                                    <td>{!! $TipoAccionJira['tiaj_sucesor'] !!}</td>
                                    <td>{{ $TipoAccionJira['tiaj_estado'] }}</td>
                                    <td>{{ $TipoAccionJira['tiaj_codigo'] }}</td>
                                    <td>
                                        <a href="{{ url("admin/tipoaccionjira/".$TipoAccionJira['tiaj_id']) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('edit jira')
                                        <a href="{{ url("admin/tipoaccionjira/".$TipoAccionJira['tiaj_id']."/edit") }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan 
                                        @can('delete jira')
                                        <a href="{{ url("admin/tipoaccionjira/".$TipoAccionJira['tiaj_id']."/delete") }}" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @endcan                                
                                    </td>
                                </tr>
                            @endforeach 
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Estado</th>
                                    <th>Nombre</th>
                                    <th>Activo</th>
                                    <th>Indice</th>
                                    <th>Actual</th>
                                    <th>Siguiente</th>
                                    <th>Acción</th>
                                    <th>Sucesores</th>
                                    <th>Caracter del</th>
                                    <th>Código</th>
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
            var table = $('#jira_table').DataTable({
                "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]],
                "order": [[ 3, "asc" ]],
                "scrollX": true,
                language: {
                    url: "{{ mix('i18n/es_es.json') }}"
                },
                columnDefs: [
                    
                    { orderable: false, targets: 10 },
            ],
            });
        } );
    //    $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm";
    //    $.fn.DataTable.ext.classes.sLengthSelect  = "form-control form-control-sm";

      </script>
@endsection