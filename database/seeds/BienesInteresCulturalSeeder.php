<?php

use Illuminate\Database\Seeder;
use App\Imports\BienCulturalImport;
use Maatwebsite\Excel\Facades\Excel;

class BienesInteresCulturalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new BienCulturalImport,'documentos/Bienes_interes_cultural_cyl.xlsx');
    }
}
