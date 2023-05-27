@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titulo-edicion">
                    @if(isset($usuario))
                        Editar usuario
                    @else
                        Crear usuario
                    @endif
                </div>
                @if(isset($usuario))
                    {!! Form::model($usuario, array('route' => ['usuarios.actualizar', $usuario->id], 'method' => 'PUT', 'role' => 'form', 'id' => 'formulario')) !!}
                @else
                    {!! Form::open(array('route' => ['usuarios.insertar'], 'method' => 'POST', 'role' => 'form', 'id' => 'formulario')) !!}
                @endif
            </div>
            <div class="col-md-12">
                <div class="form-background">
                    <div class="col-md-4 d-inline-block">
                        {!! Form::label('nombre_completo', 'Nombre completo') !!}
                        {!! Form::text('nombre_completo', null, array('class' => 'form-control'.(($errors->has('nombre_completo')) ? ' is-invalid-input' : ''), 'id' => 'nombre_completo','required' => 'required')) !!}
                        @if($errors->has('nombre_completo'))
                            <span class="form-error is-visible">{{ $errors->first('nombre_completo') }}</span>
                        @endif
                    </div>
                    <div class="col-md-4 d-inline-block">
                        {!! Form::label('email', 'E-mail (usuario)') !!}
                        {!! Form::email('email', null, array('class' => 'form-control'.(($errors->has('email')) ? ' is-invalid-input' : ''), 'id' => 'email', 'required' => 'required','type' => 'email')) !!}
                        @if($errors->has('email'))
                            <span class="form-error is-visible">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="col-md-3 d-inline-block">
                        {!! Form::label('rol_id', 'Rol') !!}
                        {!! Form::select('rol_id', $roles, null, array('class' => 'form-control'.(($errors->has('rol_id')) ? ' is-invalid-input' : ''), 'id' => 'rol_id')) !!}
                    </div>
                </div>
                <div class="form-background">
                    @if(!isset($usuario))
                        <div class="col-md-4 d-inline-block">
                            {!! Form::label('password', 'Contraseña') !!}
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @if($errors->has('password'))
                                <span class="form-error is-visible">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    @endif
                    <div class="col-md-4 d-inline-block">
                        {!! Form::label('telefono', 'Teléfono') !!}
                        {!! Form::text('telefono', null, array('class' => 'form-control'.(($errors->has('telefono')) ? ' is-invalid-input' : ''), 'id' => 'telefono')) !!}
                        @if($errors->has('telefono'))
                            <span class="form-error is-visible">{{ $errors->first('telefono') }}</span>
                        @endif
                    </div>
                    @if(isset($usuario))
                        <div class="col-md-3 d-inline-block">
                            {!! Form::label('activo', 'Activo') !!}
                            {{ Form::checkbox('activo',null,null, array('id'=>'activo')) }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12" style="margin-top:1em;">
                <a href="{{route('usuarios.index')}}" class="btn btn-secondary btn-back">Atrás</a>
                <button class="btn btn-primary btn-save" type="submit">Guardar</button>
            </div>
        </div>
            {!! Form::close() !!}
    </div>
@endsection