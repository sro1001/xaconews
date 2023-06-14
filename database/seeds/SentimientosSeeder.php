<?php

use Illuminate\Database\Seeder;

class SentimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sentimientos')->insert([
            'id' => 1,
            'nombre' => 'Alegría',
            'positivo' => 1
        ]);
        DB::table('sentimientos')->insert([
            'id' => 2,
            'nombre' => 'Tristeza',
            'positivo' => 0
        ]);
        DB::table('sentimientos')->insert([
            'id' => 3,
            'nombre' => 'Confianza',
            'positivo' => 1
        ]);
        DB::table('sentimientos')->insert([
            'id' => 4,
            'nombre' => 'Miedo',
            'positivo' => 0
        ]);
        DB::table('sentimientos')->insert([
            'id' => 5,
            'nombre' => 'Orgullo',
            'positivo' => 1
        ]);
        DB::table('sentimientos')->insert([
            'id' => 6,
            'nombre' => 'Enfado',
            'positivo' => 0
        ]);
        DB::table('sentimientos')->insert([
            'id' => 7,
            'nombre' => 'Satisfacción',
            'positivo' => 1
        ]);
        DB::table('sentimientos')->insert([
            'id' => 8,
            'nombre' => 'Asco',
            'positivo' => 0
        ]);
        DB::table('sentimientos')->insert([
            'id' => 9,
            'nombre' => 'Amor',
            'positivo' => 1
        ]);
        DB::table('sentimientos')->insert([
            'id' => 10  ,
            'nombre' => 'Culpa',
            'positivo' => 0
        ]);
        DB::table('sentimientos')->insert([
            'id' => 11  ,
            'nombre' => 'Positividad',
            'positivo' => 0
        ]);
    }
}
