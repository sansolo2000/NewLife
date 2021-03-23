@extends('admin.layouts.master')

@section('title', 'Consulta Usuarios')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url("admin/user") }}" class="btn btn-secondary mb-3">
                Volver
            </a>
        </div>
        <div class="col-md-12">

            @include('message.alert')

            <div class="card card-body">
                <form action="{{ url("admin/user/$user->id") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                {{ Form::text('name', $user->name, array('class' => 'form-control', 'disabled' => 'disabled')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                {{ Form::email('email', $user->email, array('class' => 'form-control', 'disabled' => 'disabled')) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Área</label>
                                {{ Form::select('area', $areas,  $user->area,  array('class' => 'custom-select', 'id' => 'area', 'disabled' => 'disabled')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role</label>
                                {{ Form::select('role', $roles, $user->role_id, array('class' => 'custom-select', 'disabled' => 'disabled')) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password: <i class="text-info">(Default: password)</i></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo versión</label>
                                @foreach ($TiposJiras as $key => $TipoJira)
                                <div class="checkbox">
                                    <label>
                                        <input  name="tiji[]" type="checkbox" value="{{ $key+1 }}" {{ $TiposJirasUsersNew[$key+1] }} disabled="disabled">
                                        {{ $TipoJira->tiji_nombre }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection