<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'nombre' => 'Administrador',
        ]);
        DB::table('roles')->insert([
            'id' => 2,
            'nombre' => 'Editor',
        ]);
        DB::table('roles')->insert([
            'id' => 3,
            'nombre' => 'Lector',
        ]);
    }
}
