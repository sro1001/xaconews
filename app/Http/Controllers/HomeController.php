<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\NoticiaEstado;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $noticias = Noticia::whereIn('estado_id',[NoticiaEstado::VISIBLE,NoticiaEstado::VISIBLE_ANALIZADA])->get();
        return view('home', [
            'noticias' => $noticias
        ]);
    }
}
