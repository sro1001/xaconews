<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Noticias\NoticiasController;

class SincronizacionNoticias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'noticias:sincronizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronización nocturna de noticias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new NoticiasController)->sincronizar_noticias();
    }
}