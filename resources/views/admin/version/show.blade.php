@extends('admin.layouts.master')

@section('title')
    {{ $Version->vers_nombre }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('admin/version') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
            @include('message.alert')
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Detalle de la versión - {{ $Version->vers_nombre }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nombre de versión:</label>
                                        <input type="text" name="vers_nombre" value="{{ $Version->vers_nombre }}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha:</label>
                                        <input type="text" name="vers_fecha_creacion" value="{{ $Version->vers_fecha_creacion_format() }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Usuario:</label>
                                        <input type="text" name="user_nombre" value="{{ $Version->user_nombre }}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Responsable Actual:</label>
                                        <input type="text" name="tiaj_responsable_actual" value="{{ $Version->tiaj_responsable_actual }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Estado:</label>
                                        <input type="text" name="tiaj_estado" value="{{ $Version->tiaj_estado }}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tipo versión</label>
                                    @foreach ($TiposJiras as $key => $TipoJira)
                                        <div class="checkbox">
                                            <label>
                                                <input  name="tiji[]" type="checkbox" value="{{ $key+1 }}" {{ $TipoVersionNew[$key+1] }} disabled="disabled">
                                                {{ $TipoJira->tiji_nombre }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>                            
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-11">
                                        <h3 class="card-title">Acciones realizadas</h3>
                                    </div>
                                    @can('create versionaccion')
                                        <div class="col-md-1">
                                            <a href="{{ url("admin/versionaccion/create/$Version->vers_id") }}" class="btn btn-warning {{ ($Version->tiaj_responsable_siguiente == $user->area && $crear) ? '' : 'disabled' }}">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="acciones_jira" class="table table-bordered table-hover text-xs">
                                        <thead>
                                            <tr>
                                                <th>Operación</th>
                                                <th>Descripción</th>
                                                <th>Fecha</th>
                                                <th>Usuario</th>
                                                <th>Evidencia</th>
                                                <th>Acciones</th>                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($VersionesAcciones as $VersionAccion)
                                            <tr>
                                                <td width='10%'>{{ $VersionAccion->tiaj_nombre }}</td>
                                                <td width='20%'>{{ $VersionAccion->veac_nombre_limite() }}</td>
                                                <td width='15%'>{{ $VersionAccion->veac_fecha_format() }} </td>
                                                <td width='15%'>{{ $VersionAccion->user_nombre }} </td>
                                                <td width='10%' style="text-align: center;">
                                                    <a href="{{ url("admin/versionaccion/$Version->vers_id/$VersionAccion->veac_id/download") }}" class="btn btn-info btn-sm {{ is_null($VersionAccion->veac_ruta) ? 'disabled' : '' }}">
                                                        <i class="fas {{ is_null($VersionAccion->veac_ruta) ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                                    </a>
                                                </td>
                                                <td width='30%'>
                                                    <a href="{{ url("admin/versionaccion/$Version->vers_id/$VersionAccion->veac_id") }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @can('edit versionaccion')
                                                        <a href="{{ url("admin/versionaccion/$Version->vers_id/$VersionAccion->veac_id/edit") }}" class="btn btn-success btn-sm {{ ($VersionAccion->tiaj_responsable_actual == $user->area) ? '' : 'disabled' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan 
                                                    @can('delete versionaccion')
                                                        <a href="{{ url("admin/versionaccion/$Version->vers_id/$VersionAccion->veac_id/delete") }}" class="btn btn-danger btn-sm {{ ($VersionAccion->tiaj_responsable_actual == $user->area) ? '' : 'disabled' }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    @endcan                                
                                                </td>
                                            </tr>
                                            @endforeach                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready( function () {
        var table = $('#acciones_jira').DataTable({
            "paging":       false,
            "ordering":     false,
            "searching":    false,
            "info":         false,
            language: {
                url: "{{ mix('i18n/es_es.json') }}"
            },
            columnDefs: [
            { orderable: false, targets: 5 }, 
            { type: 'date-euro', targets: 2 }
        ],
        });
    } );

  </script>
@endsection