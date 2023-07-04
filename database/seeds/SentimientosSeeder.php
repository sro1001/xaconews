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
            'nombre' => 'Alegría'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 2,
            'nombre' => 'Tristeza'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 3,
            'nombre' => 'Confianza'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 4,
            'nombre' => 'Miedo'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 5,
            'nombre' => 'Orgullo'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 6,
            'nombre' => 'Enfado'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 7,
            'nombre' => 'Satisfacción'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 8,
            'nombre' => 'Asco'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 9,
            'nombre' => 'Amor'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 10  ,
            'nombre' => 'Culpa'
        ]);
        DB::table('sentimientos')->insert([
            'id' => 11  ,
            'nombre' => 'Positividad'
        ]);
    }
}
