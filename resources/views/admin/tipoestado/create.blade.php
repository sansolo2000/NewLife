@extends('admin.layouts.master')

@section('title', 'Crear tipo de estado')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{-- <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3"> --}}
            <a href="{{ url('admin/tipoestado') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">

            @if (!$errors->any())
                @include('message.alert')
            @endif
            <div class="card card-body">
                <form action="{{ url('admin/tipoestado') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="ties_nombre" class="form-control" value="{{old('ties_nombre')}}">
                        @if ($errors->has('ties_nombre'))
                            <small class="form-text text-danger">
                                {{ $errors->first('ties_nombre') }}
                            </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Indice</label>
                        @php print('hola'); @endphp {{ old('ties_indice') ?? $tipoestado->ties_indice ?? 'cccc' }}
                        <input type="text" name="ties_indice" class="form-control" value="{{old('ties_indice')}}">
                        @if ($errors->has('ties_indice'))
                            <small class="form-text text-danger">
                                {{ $errors->first('ties_indice') }}
                            </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Activo</label>
                        {{ Form::select('ties_activo', ['' => 'Seleccione una opción', 'S' => 'Sí', 'N' => 'No'], old('ties_activo'), array('class' => 'custom-select')) }}
                        @if ($errors->has('ties_activo'))
                            <small class="form-text text-danger">
                                {{ $errors->first('ties_activo') }}
                            </small>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection