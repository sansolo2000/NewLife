@extends('admin.layouts.master')

@section('title', 'Crear nuevo comentario')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('admin/notes/'.$Jira->jira_id) }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">
            @if (!$errors->any())
                @include('message.alert')
            @endif
            <form action="{{ url('admin/notes/'.$Jira->jira_id.'/new') }}" method="post" enctype="multipart/form-data">
                @csrf 
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $Jira->jira_asunto }}</h3>
                        <div class="card-tools">
                            <span class="badge badge-primary">{{ $Jira->jira_codigo }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Titulo:</label>
                                    <input type="text" name="noji_asunto" value="{{ old('noji_asunto') }}" class="form-control">
                                    @include('message.controlerror', ['control' => 'noji_asunto'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Descripción:</label>
                                    {{ Form::textarea('noji_descripcion', old('noji_descripcion'), ['class'=>'form-control','id'=>'noji_descripcion', 'rows'=>'3']) }}
                                    @include('message.controlerror', ['control' => 'noji_descripcion'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="noji_ruta">Evidencia:</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            {{ Form::file('noji_ruta', array('clase' => 'custom-file-input', 'id' => 'noji_ruta')) }}
                                            <label class="custom-file-label" for="noji_ruta">Seleccione</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">Subir</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Crear Comentario</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
</script>
@endsection