@extends('admin.layouts.master')

@section('title', 'Category Create')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{-- <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3"> --}}
            <a href="{{ url('admin/category') }}" class="btn btn-secondary mb-3">
                Back
            </a>
        </div>
        <div class="col-md-12">

            @include('message.danger')

            <div class="card card-body">
                <form action="{{ url('admin/category') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="ties_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Indice</label>
                        <input type="text" name="ties_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Activo</label>
                        <select name="ties_activo">
                            <option value="-1" selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                          </select> 
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection