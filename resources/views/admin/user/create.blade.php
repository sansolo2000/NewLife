@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @include('message.alert')
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create User</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ url('admin/user/store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password: <i class="text-info">(Default: password)</i></label>
                                    <input type="password" name="password" value="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role</label>
                                    {{ Form::select('role', $roles, old('role'), array('class' => 'custom-select')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Área</label>
                                    {{ Form::select('area', $areas, old('area'), array('class' => 'custom-select', 'id' => 'area')) }}
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
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

@endsection