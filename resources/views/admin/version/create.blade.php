@extends('admin.layouts.master')

@section('title', 'Crear Versión')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('admin/version') }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">
            {{-- @if (!$errors->any()) --}}
                @include('message.alert')
            {{-- @endif --}}
            <div class="card card-body">
                <form action="{{ url('admin/version') }}" method="post" enctype="multipart/form-data">
                    @csrf 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre de versión</label>
                                <input type="text" name="vers_nombre" value="{{ old('vers_nombre') }}" class="form-control">
                                @include('message.controlerror', ['control' => 'vers_nombre'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo versión</label>
                                @foreach ($TiposJiras as $TipoJira)
                                    <div class="checkbox">
                                        <label>{{ Form::checkbox('tiji[]', $TipoJira->tiji_id, TipoVersionChecked(old('tiji'), null)) }}  {{ $TipoJira->tiji_nombre }}</label>
                                    </div>
                                @endforeach
                                @include('message.controlerror', ['control' => 'tiji'])
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection