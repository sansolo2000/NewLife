<table id="jira_accion_table" class="table table-striped dataTable text-xs" role="grid">
    <thead>
        <tr>
            <th width="20%">Fecha última acción</th>
            <th width="20%">Jira</th>
            <th width="60%">Descripción</th>
        </tr>
    </thead>                        
    <tbody>
    @foreach ($JirasAcciones as $JiraAccion)
        <tr>
            <td>{{ $JiraAccion->jiac_fecha_format() }}</td>
            <td>{{ $JiraAccion->jira_codigo }}</td>
            <td>{{ $JiraAccion->jiac_descripcion }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Fecha</th>
            <th>Jira</th>
            <th>Descripción</th>
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