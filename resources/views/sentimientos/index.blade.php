@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="titulo-estadisticas ">
                Estadísticas de sentimientos
            </div>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Puntuación de positividad en las noticias</div>
                <canvas id="positiveChart" style="margin-top:1em"></canvas>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card" style="margin-top:1em">
                <div class="card-header" >Valores de puntuación por sentimiento</div>
                <canvas id="sentimientosChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    @include('sentimientos.script_graficos')
@endsection