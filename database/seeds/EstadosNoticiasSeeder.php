<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosNoticiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('noticias_estados')->insert([
            'id' => 1,
            'nombre' => 'Sin revisar',
        ]);
        DB::table('noticias_estados')->insert([
            'id' => 2,
            'nombre' => 'Visible',
        ]);
        DB::table('noticias_estados')->insert([
            'id' => 3,
            'nombre' => 'Oculto',
        ]);
    }
}
