@extends('admin.layouts.master')

@section('title', 'Jiras')

@section('content')
    <div class="container-fluid">
        <!-- Create and Search (Start) -->
        <div class="row">
            <div class="col-md-12">
                @include('message.alert')
            </div>
            @can('create jira')
            <div class="col-md-6">
                <a href="{{ url('admin/jira/create') }}" class="btn btn-primary mb-3">
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
                        <table id="jira_table" class="table table-striped dataTable text-xs" role="grid">
                            <thead>
                                <tr>
                                    <th width="10%">Codigo</th>
                                    <th width="16%">Asunto</th>
                                    <th width="12%">Fecha de creación</th>
                                    <th width="12%">Estado</th>
                                    <th width="8%">Responsable actual</th>
                                    <th width="12%">Fecha última acción</th>                                    
                                    <th width="12%">Versión</th>
                                    <th width="18%">Acciones</th>
                                </tr>
                            </thead>                        
                            <tbody>
                            @foreach ($jiras as $jira)
                                <tr>
                                    <td>{{ $jira->jira_codigo }}</td>
                                    <td>{{ $jira->jira_asunto }}</td>
                                    <td>{{ $jira->jira_fecha_format() }}</td>
                                    <td>{{ $jira->ties_nombre }}</td>
                                    <td>{{ ($jira->tiaj_responsable_siguiente == 'Interno') ? 'Indra' : 'HLF' }}</td>
                                    <td>{{ $jira->jiac_fecha_format() }}</td>
                                    <td>{{ $jira->vers_nombre }} </td>
                                    <td>
                                        <a href="{{ url("admin/jira/$jira->jira_id") }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('edit jira')
                                        <a href="{{ url("admin/jira/$jira->jira_id/edit") }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan 
                                        @can('delete jira')
                                        <a href="{{ url("admin/jira/$jira->jira_id/delete") }}" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @endcan                                
                                        @can('notes jira')
                                        <a href="{{ url("admin/notes/$jira->jira_id") }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-sticky-note"></i>
                                        </a>
                                        @endcan                                
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="10%">Codigo</th>
                                    <th width="16%">Asunto</th>
                                    <th width="12%">Fecha de creación</th>
                                    <th width="12%">Estado</th>
                                    <th width="8%">Responsable actual</th>
                                    <th width="12%">Fecha última acción</th>                                    
                                    <th width="12%">Versión</th>
                                    <th width="18%">Acciones</th>
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
                language: {
                    url: "{{ mix('i18n/es_es.json') }}"
                },
                columnDefs: [
                { orderable: false, targets: 6 },
                { type: 'date-euro', targets: 3 }
            ],
            });
        } );
    //    $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm";
    //    $.fn.DataTable.ext.classes.sLengthSelect  = "form-control form-control-sm";

      </script>
@endsection