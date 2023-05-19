<?php

use Illuminate\Database\Seeder;

class SincronizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sincronizacion_noticias')->insert([
            'id' => 1,
            'limite_llamadas_api_noticias' => 499,
            'limite_llamadas_chatGPT' => 25,
        ]);
    }
}
