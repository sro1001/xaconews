@extends('layouts.app')

@section('content')
    <section>
        <div class="callout large">
            <div class="row p-top-1">
                <div class="medium-12 column">
                        <div class="titulo1">Revisar noticia</div>
                        {!! Form::model($noticia ,array('route' => ['noticias.revision', $noticia], 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'formulario')) !!}
                        <div class="p-top-1 clear cnt-save-cancel">
                            <a href="{{route('noticias.index')}}" class="btn-cancel">Cancelar</a>
                            <button class="btn-save" type="submit">Guardar</button>
                        </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection