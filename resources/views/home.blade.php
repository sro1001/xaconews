@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                @foreach($noticias as $noticia)
                    <div class="col-md-12 div-contenedor-dashboard">
                        <div class="div-noticias-dashboard">
                            <div class="titulo-noticia-ds">
                                {{$noticia->titulo}}
                            </div>
                            <div class="contenido-noticia-ds">
                                @foreach(array_slice($noticia->formatearTexto(), 0, 5) as $linea_noticia)
                                    <div class="col-md-12 linea-noticia-ds">
                                        {{$linea_noticia}}
                                    </div>
                                @endforeach
                                <div class="col-md-12 linea-noticia-ds">
                                    ...
                                </div>
                                <a class="btn btn-primary btn-ver-mas" href="{{route('noticias.ver_noticia_dashboard', $noticia->id)}}">Ver más</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
