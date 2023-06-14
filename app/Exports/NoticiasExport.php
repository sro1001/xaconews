<?php

namespace App\Exports;

use App\Models\Noticia;
use App\Models\Sentimiento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class NoticiasExport implements FromCollection, WithColumnWidths, WithStyles
{
    public function collection()
    {
        $coleccion_noticias = new Collection();
        $cabecera = ["Título","Fecha","Fuente","BienCultural","Municipio","Provincia","Estado","URL","Texto","Alegría","Tristeza","Confianza","Miedo","Orgullo","Enfado","Satisfacción","Asco","Amor","Culpa","Positivo"];
        $coleccion_noticias->push($cabecera);
        $noticias = Noticia::all();
        foreach($noticias as $noticia){
            $coleccion_noticias->push((object)[
                $noticia->titulo,
                $noticia->fecha->format('d-m-Y'),
                $noticia->fuente->nombre,
                $noticia->bien_interes_cultural->nombre,
                $noticia->bien_interes_cultural->municipio->nombre,
                $noticia->bien_interes_cultural->provincia->nombre,
                $noticia->estado->nombre,
                $noticia->url,
                substr($noticia->texto, 0, Noticia::MAX_CHARS_TEXTO_EXCEL),
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::ALEGRIA)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::ALEGRIA)->get()[0]->pivot->puntuacion:
                    "0",
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::TRISTEZA)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::TRISTEZA)->get()[0]->pivot->puntuacion:
                    "0",
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::CONFIANZA)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::CONFIANZA)->get()[0]->pivot->puntuacion:
                    "0",
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::MIEDO)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::MIEDO)->get()[0]->pivot->puntuacion:
                    "0",
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::ORGULLO)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::ORGULLO)->get()[0]->pivot->puntuacion:
                    "0",
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::ENFADO)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::ENFADO)->get()[0]->pivot->puntuacion:
                    "0",
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::SATISFACCION)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::SATISFACCION)->get()[0]->pivot->puntuacion:
                    "0",
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::ASCO)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::ASCO)->get()[0]->pivot->puntuacion:
                    "0",
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::AMOR)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::AMOR)->get()[0]->pivot->puntuacion:
                    "0",
                (count($noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::CULPA)->get()) > 0) ?
                    $noticia->sentimientos()->where('sentimiento_id','=',Sentimiento::CULPA)->get()[0]->pivot->puntuacion:
                    "0",
                "10"
            ]);
        }
        return $coleccion_noticias;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 90,
            'B' => 12,
            'C' => 25,
            'D' => 32,
            'E' => 19,
            'F' => 10,
            'G' => 16,
            'H' => 80,
            'I' => 120,
            'J' => 10,
            'K' => 10,
            'L' => 10,
            'M' => 10,
            'N' => 10,
            'O' => 10,
            'P' => 10,
            'Q' => 10,
            'R' => 10,
            'S' => 10,
            'T' => 10,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

}