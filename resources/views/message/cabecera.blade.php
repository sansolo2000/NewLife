@if ($Cabeceras <> '')
    @foreach ($Cabeceras as $key => $Cabecera)
        <div class="modal fade" id="cabecera-{{ $key }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">{{ $Cabecera['noji_asunto'] }}</h6>
                        <div class="card-tools">
                            <span class="badge badge-primary">{{ $Jira->jira_codigo }}</span>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-xs">
                                Fecha:
                            </div>
                            <div class="col-md-8 text-xs">
                                {{ $Cabecera['noji_fecha'] }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-xs">
                                Usuario:
                            </div>
                            <div class="col-md-8 text-xs">
                                {{ $Cabecera['user_name'] }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-xs">
                                Descripción:
                            </div>
                            <div class="col-md-8 text-xs">
                                {{ $Cabecera['noji_descripcion'] }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-xs">
                                Adjunto:
                            </div>
                            <div class="col-md-8 text-xs">
                                <a href="{{ url("admin/notes/$key/download") }}" class="btn btn-info btn-sm {{ is_null($Cabecera['noji_ruta']) ? 'disabled' : '' }}">
                                    <i class="fas {{ is_null($Cabecera['noji_ruta']) ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endif
