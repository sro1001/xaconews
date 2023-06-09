@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if($vision_dashboard)
                    <div class="titulo-noticia-ver-ds">
                        {{$noticia->titulo}}
                    </div>
                @else
                    <div class="titulo-noticia">
                        Revisión de la noticia
                    </div>
                    {!! Form::model($noticia ,array('route' => ['noticias.revision', $noticia->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'formulario')) !!}
                @endif
            </div>
            @if(!$vision_dashboard)
                <div class="col-md-12">
                    @if($edicion_texto)
                        <div class="info-noticia">
                            <div class="col-md-12">
                                <b>Título:</b> {!! Form::text('titulo', null, array('style'=>'height:auto;margin-bottom: 0.4em;','class' => 'form-control'.(($errors->has('titulo')) ? ' is-invalid-input' : ''), 'id' => 'titulo')) !!}
                            </div>
                    @else
                        <div class="info-noticia">
                            <div class="col-md-12">
                                <b>Título:</b> {{$noticia->titulo}}
                            </div>
                    @endif
                        <div class="col-md-12">
                            <b>Fuente:</b> {{$noticia->fuente->nombre}}
                        </div>
                        <div class="col-md-12">
                            <b>Fecha:</b> {{$noticia->fecha->format('d-m-Y')}}
                        </div>
                        <div class="col-md-12">
                            <b>Bien cultural:</b> {{$noticia->bien_interes_cultural->nombre}}
                        </div>
                        <div class="col-md-12">
                            <b>Municipio:</b> {{$noticia->bien_interes_cultural->municipio->nombre}}
                        </div>
                        <div class="col-md-12">
                            <b>Provincia:</b> {{$noticia->bien_interes_cultural->provincia->nombre}}
                        </div>
                        <div class="col-md-12 link-noticia">
                            <b>Noticia original:</b>&nbsp;&nbsp;<a href="{{$noticia->url}}" class="btn btn-xs btn-primary" target="_blanck"><ion-icon name="arrow-redo-circle"></ion-icon></a>
                        </div>
                        @if($noticia->estado_id != App\Models\NoticiaEstado::VISIBLE_ANALIZADA)
                            <div class="col-md-4">
                                {!! Form::label('estado_id', 'Estado de la noticia', array('style' => 'font-weight:bold;')) !!}
                                {!! Form::select('estado_id', $noticias_estados, null, array('class' => 'form-control'.(($errors->has('estado_id')) ? ' is-invalid-input' : ''), 'id' => 'estado_id')) !!}
                            </div>
                        @else
                            <div class="col-md-12 link-noticia">
                                <b>Estado de la noticia:</b> {{$noticia->estado->nombre}}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                @if(!$vision_dashboard && $edicion_texto)
                    <div class="edicion-noticia">
                        {!! Form::label('texto', 'Texto de la noticia', array('class' => 'fondo-titulo-noticia')) !!}
                        {!! Form::textarea('texto', null, array('style'=>'height:auto;','class' => 'form-control'.(($errors->has('nombre')) ? ' is-invalid-input' : ''), 'id' => 'texto')) !!}
                    </div>
                @else
                    @if($noticia->estado_id != App\Models\NoticiaEstado::VISIBLE_ANALIZADA && !$vision_dashboard)
                        <button class="btn btn-primary btn-editar-noticia" name="editar_texto"> Editar noticia</button>
                    @endif
                    <div class="contenido-noticia">
                        @foreach($noticia->formatearTexto() as $linea_noticia)
                            <div class="col-md-12 linea-noticia">
                                {{$linea_noticia}}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @if($noticia->estado_id == App\Models\NoticiaEstado::VISIBLE_ANALIZADA && !$vision_dashboard && Auth::user()->rol_id == App\Models\Rol::ADMIN)
                <div class="col-md-12">
                    <div class="titulo-sentimientos">
                        Sentimientos de la noticia
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="div-tabla-sentimientos">
                        <table class="tabla-sentimientos">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Puntuación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($noticia->sentimientos()->orderBy('puntuacion','desc')->get() as $sentimiento)
                                    <tr>
                                        <th>{{$sentimiento->nombre}}</th>
                                        <th class="text-center">{{$sentimiento->pivot->puntuacion}}</th>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            @endif
            <div class="col-md-12" style="margin-top:1em;">
                @if($vision_dashboard)
                    <a href="{{route('home')}}" class="btn btn-secondary btn-back">Atrás</a>
                @else
                    <a href="{{route('noticias.index')}}" class="btn btn-secondary btn-back">Atrás</a>
                    @if($noticia->estado_id != App\Models\NoticiaEstado::VISIBLE_ANALIZADA)
                        <button class="btn btn-primary btn-save" type="submit">Guardar</button>
                    @endif
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('noticias.edicion_script')
@endsection