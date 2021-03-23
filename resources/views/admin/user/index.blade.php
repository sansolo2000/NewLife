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
                <a href="{{ url('admin/user/create') }}" class="btn btn-primary mb-3">
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
                                    <th width="20%">Nombre</th>
                                    <th width="15%">Email</th>
                                    <th width="15%">Rol</th>
                                    <th width="15%">tipo de Jira</th>
                                    <th width="23%">Acciones</th>
                                </tr>
                            </thead>                        
                            <tbody>
                            @foreach ($Users as $User)
                                <tr>
                                    <td>{{ $User['id'] }}</td>
                                    <td>{{ $User['name'] }}</td>
                                    <td>{{ $User['email'] }}</td>
                                    <td>{{ $User['rol'] }}</td>
                                    <td><ul>{!! $User['tiji_nombre'] !!}</ul></td>
                                    <td>
                                        <a href="{{ url("admin/user/".$User['id']) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('edit version')
                                        <a href="{{ url("admin/user/".$User['id']."/edit") }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan 
                                        @can('delete version')
                                        <a href="{{ url("admin/version/".$User['id']."/delete") }}" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @endcan                                                           
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="12%">Id</th>
                                    <th width="20%">Nombre</th>
                                    <th width="15%">Email</th>
                                    <th width="15%">Role</th>
                                    <th width="15%">tipo de Jira</th>
                                    <th width="23%">Acciones</th>
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