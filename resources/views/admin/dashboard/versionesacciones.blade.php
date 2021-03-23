<table id="version_accion_table" class="table table-striped dataTable text-xs" role="grid">
    <thead>
        <tr>
            <th width="20%">Fecha última acción</th>
            <th width="20%">Nombre Versión</th>
            <th width="60%">Descripción</th>
        </tr>
    </thead>                        
    <tbody>
    @foreach ($VersionesAcciones as $VersionAccion)
        <tr>
            <td>{{ $VersionAccion->veac_fecha_format() }}</td>
            <td>{{ $VersionAccion->vers_nombre }}</td>
            <td>{{ $VersionAccion->veac_nombre }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Fecha</th>
            <th>Nombre Versión</th>
            <th>Descripción</th>
        </tr>
    </tfoot>                          
</table>

<script>
    $(document).ready( function () {
        var table = $('#version_accion_table').DataTable({
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
