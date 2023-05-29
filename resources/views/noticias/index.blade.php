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
                            {!! Form::label('titulo', 'Título') !!}
                            {!! Form::text('titulo', null, array('class' => 'form-control', 'id' => 'titulo')) !!}
                        </div>
                        <div class="col-md-3 d-inline-block">
                            {!! Form::label('fuente_id', 'Fuente') !!}
                            {!! Form::select('fuente_id', $fuentes_buscador, null, array('class' => 'form-control select2', 'id' => 'fuente_id', 'placeholder' => '** Todas las fuentes **')) !!}
                        </div>
                        <div class="col-md-3 d-inline-block">
                            {!! Form::label('municipio_id', 'Municipio') !!}
                            {!! Form::select('municipio_id', $municipios_buscador, null, array('class' => 'form-control select2', 'id' => 'municipio_id', 'placeholder' => '** Todos los municipios **')) !!}
                        </div>
                        <div class="col-md-2 d-inline-block col-end">
                            {!! Form::label('provincia_id', 'Provincia') !!}
                            {!! Form::select('provincia_id', $provincias_buscador, null, array('class' => 'form-control select2', 'id' => 'provincia_id', 'placeholder' => '** Todas las provincias **')) !!}
                        </div>
                    </div>
                    <div style="width: 100%; margin-top:1em;">
                        <div class="col-md-6 d-inline-block">
                            {!! Form::label('bien_cultural_id', 'Bienes de interés cultural') !!}
                            {!! Form::select('bien_cultural_id', $bienes_buscador, null, array('class' => 'form-control select2', 'id' => 'bien_cultural_id', 'placeholder' => '** Todos las bienes **')) !!}
                        </div>
                        <div class="col-md-3 d-inline-block">
                            {!! Form::label('estado_id', 'Estado') !!}
                            {!! Form::select('estado_id', $estados_buscador, null, array('class' => 'form-control select2', 'id' => 'estado_id', 'placeholder' => '** Todos los estados **')) !!}
                        </div>
                        <button class="button btn-search" id="buscar">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="titulo-listado">
                    Listado de noticias
                </div>
            </div>
            <div class="col-md-12">
                <div class="cnt-table1">
                    <table class="table stack tabla1" id="tabla">
                        <thead>
                        <tr>
                            <th>Título</th>
                            <th>Fuente</th>
                            <th>Bien cultural</th>
                            <th>Municipio</th>
                            <th>Provincia</th>
                            <th>Estado</th>
                            <th width="160px">Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('noticias.script')
@endsection