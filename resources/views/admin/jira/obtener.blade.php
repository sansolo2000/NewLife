@extends('admin.layouts.master')

@section('title')
    {{ $jira->jira_codigo }}
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('admin/jira/'.$jira->jira_id) }}" class="btn btn-secondary mb-3">
                Volver
            </a>
            @include('message.alert')
        </div>
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="card-title">Incidentes asociados al jira - {{ $jira->jira_codigo }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Asunto:</label>
                                <input type="text" name="jira_asunto" value="{{ $jira->jira_asunto }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="acciones_jira" class="table table-bordered table-hover text-xs">
                                <thead>
                                    <tr>
                                        <th>Número de Ticket</th>
                                        <th>Técnico</th>
                                        <th>Asunto</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>                                            
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($IncidentesShow as $IncidenteShow)
                                    <tr>
                                        <td width='20%'>{{ $IncidenteShow->inci_numero }}</td>
                                        <td width='20%'>{{ $IncidenteShow->inci_tecnico }}</td>
                                        <td width='20%'>{{ $IncidenteShow->inci_asunto }} </td>
                                        <td width='20%'>{!! $IncidenteShow->inci_descripcion_limite() !!} </td>
                                        <td width='20%'>{{ $IncidenteShow->inci_fecha_format() }} </td>
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