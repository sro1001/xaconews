@extends('layouts.app')

@section('content')
    <section>
        <div class="callout large">
            <div class="row p-top-1">
                <div class="medium-12 column">
                    @if(isset($tipo))
                        <div class="titulo1">Editar tipo</div>
                        {!! Form::model($tipo ,array('route' => ['admin.formacion.tipo.actualizar', $tipo], 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'formulario')) !!}
                    @else
                        <div class="titulo1">Nuevo tipo</div>
                        {!! Form::open(array('route' => ['admin.formacion.tipo.insertar'], 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'formulario')) !!}
                    @endif
                    <div class="w-100p d-inline-block background-color-blanco f-left p-bottom-b p-top-b p-bottom-b">
                        <div class="medium-4 column">
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre') !!}
                                {!! Form::text('nombre', null, array('class' => 'form-control'.(($errors->has('nombre')) ? ' is-invalid-input' : ''), 'id' => 'nombre')) !!}
                                @if($errors->has('nombre'))
                                    <span class="form-error is-visible">{{ $errors->first('nombre') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                        <div class="p-top-1 clear cnt-save-cancel">
                            <a href="{{route('admin.formacion.tipo.listar')}}" class="btn-cancel">Cancelar</a>
                            <button class="btn-save" type="submit">Guardar</button>
                        </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection