@extends('admin.layouts.master')

@section('title')
    {{ $Jira->jira_codigo }}
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('admin/jira') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
            @include('message.alert')
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $Jira->jira_asunto }}</h3>
                        <div class="card-tools">
                            <span class="badge badge-secondary">{{ $Jira->jira_codigo }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @isset($Cabeceras)
                                    @if ($Cabeceras <> '')
                                        @foreach ($Cabeceras as $key => $Cabecera)
                                            <div id="card_{{$key}}" class="card card-outline card-dark collapsed-card">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-md-2 text-xs">
                                                            {{ $Cabecera['noji_fecha'] }}
                                                        </div>
                                                        <div class="col-md-2 text-xs">
                                                            {{ $Cabecera['user_name'] }}
                                                        </div>
                                                        <div class="col-md-8 text-xs">
                                                            {{ $Cabecera['noji_asunto'] }}
                                                        </div>
                                                    </div>
                                                    <div class="card-tools">
                                                        <!-- Collapse Button -->
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cabecera-{{ $key }}"><i class="fas fa-eye"></i></button>
                                                        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                                                    </div>
                                                    <!-- /.card-tools -->
                                                </div>                                            
                                                <!-- /.card-header -->
                                                @isset($Detalles[$key])
                                                    @if ($Detalles[$key] <> '')
                                                        @foreach ($Detalles[$key] as $key2 => $Detalle)
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-2 text-xs">
                                                                        {{ $Detalle['noji_fecha'] }}
                                                                    </div>
                                                                    <div class="col-md-2 text-xs">
                                                                        {{ $Detalle['user_name'] }}
                                                                    </div>
                                                                    <div class="col-md-7 text-xs">
                                                                        {{ $Detalle['noji_asunto'] }}
                                                                    </div>
                                                                    <div class="col-md-1 text-xs">
                                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detalle-{{ $key2 }}"><i class="fas fa-eye"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endisset
                                                <div class="card-footer">
                                                    <a href="{{ url('admin/notes/'.$key.'/respond') }}" class="btn btn-primary mb-3">
                                                        <i class="fas fa-comments"></i> Respuesta
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        No hay comentarios.
                                    @endif
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('admin/notes/'.$Jira->jira_id.'/new') }}" class="btn btn-primary mb-3">
                            <i class="fas fa-comment"></i> Nuevo tema
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('message.cabecera')
@include('message.detalle')
@endsection