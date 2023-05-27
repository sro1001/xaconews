@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="titulo-buscador">
                    Buscador
                </div>
            </div>
            <div class="col-md-12 ">
                <div class="cnt-buscador">
                    <div style="width: 100%;">
                        <div class="col-md-3 d-inline-block">
                            {!! Form::label('nombre_completo', 'Nombre') !!}
                            {!! Form::text('nombre_completo', null, array('class' => 'form-control', 'id' => 'nombre_completo')) !!}
                        </div>
                        <div class="col-md-3 d-inline-block">
                            {!! Form::label('email', 'E-mail') !!}
                            {!! Form::text('email', null, array('class' => 'form-control', 'id' => 'email')) !!}
                        </div>
                        <div class="col-md-3 d-inline-block">
                            {!! Form::label('rol_id', 'Rol') !!}
                            {!! Form::select('rol_id', $roles_buscador, null, array('class' => 'form-control select2', 'id' => 'rol_id', 'placeholder' => '** Todos los roles **')) !!}
                        </div>
                        <button class="button btn-search" id="buscar">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:2em;">
            <div class="col-md-12">
                <div class="titulo-listado">
                    Listado de usuarios
                    <a href="{{route('usuarios.crear')}}" class="btn btn-primary btn-crear"> Nuevo usuario</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="cnt-table1">
                    <table class="table stack tabla1" id="tabla">
                        <thead>
                        <tr>
                            <th>Nombre completo</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Activo</th>
                            <th width="120px">Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('usuarios.script')
@endsection