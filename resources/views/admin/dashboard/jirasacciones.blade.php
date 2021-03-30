<table id="jira_accion_table" class="table table-striped dataTable text-xs" role="grid">
    <thead>
        <tr>
            <th width="20%">Fecha última acción</th>
            <th width="20%">Jira</th>
            <th width="50%">Descripción</th>
            <th width="10%">Acciones</th>
        </tr>
    </thead>                        
    <tbody>
    @foreach ($JirasAcciones as $JiraAccion)
        <tr>
            <td>{{ $JiraAccion->jiac_fecha_format() }}</td>
            <td>{{ $JiraAccion->jira_codigo }}</td>
            <td>{{ $JiraAccion->jiac_descripcion }}</td>
            <td>
                <a href="{{ url("admin/jira/$JiraAccion->jira_id") }}" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Fecha</th>
            <th>Jira</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </tfoot>                          
</table>

<script>
    $(document).ready( function () {
        var table = $('#jira_accion_table').DataTable({
            language: {
                url: "{{ mix('i18n/es_es.json') }}"
            },
            columnDefs: [
            { orderable: false, targets: 1 },
            { type: 'date-euro', targets: 0 }
        ],
        });
    } );
</script>