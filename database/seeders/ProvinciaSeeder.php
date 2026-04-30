<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciaSeeder extends Seeder
{
    public function run(): void
    {
        $provincias = [
            ['nome' => 'Luanda', 'capital' => 'Luanda', 'codigo' => 'LUA'],
            ['nome' => 'Benguela', 'capital' => 'Benguela', 'codigo' => 'BGU'],
            ['nome' => 'Huíla', 'capital' => 'Lubango', 'codigo' => 'HUI'],
            ['nome' => 'Namibe', 'capital' => 'Moçâmedes', 'codigo' => 'NAM'],
            ['nome' => 'Kwanza Sul', 'capital' => 'Sumbe', 'codigo' => 'KSU'],
            ['nome' => 'Kwanza Norte', 'capital' => 'Ndalatando', 'codigo' => 'KNO'],
            ['nome' => 'Uíge', 'capital' => 'Uíge', 'codigo' => 'UIG'],
            ['nome' => 'Malanje', 'capital' => 'Malanje', 'codigo' => 'MAL'],
            ['nome' => 'Lunda Norte', 'capital' => 'Dundo', 'codigo' => 'LNO'],
            ['nome' => 'Lunda Sul', 'capital' => 'Saurimo', 'codigo' => 'LSU'],
            ['nome' => 'Moxico', 'capital' => 'Luena', 'codigo' => 'MOX'],
            ['nome' => 'Cuando Cubango', 'capital' => 'Menongue', 'codigo' => 'CCU'],
            ['nome' => 'Bié', 'capital' => 'Kuito', 'codigo' => 'BIE'],
            ['nome' => 'Cuanza Sul', 'capital' => 'Sumbe', 'codigo' => 'CSU'],
            ['nome' => 'Cuanza Norte', 'capital' => 'Ndalatando', 'codigo' => 'CNO'],
            ['nome' => 'Zaire', 'capital' => 'Mbanza Kongo', 'codigo' => 'ZAI'],
            ['nome' => 'Cabinda', 'capital' => 'Cabinda', 'codigo' => 'CAB'],
            ['nome' => 'Bengo', 'capital' => 'Caxito', 'codigo' => 'BGO'],
            ['nome' => 'Cunene', 'capital' => 'Ondjiva', 'codigo' => 'CUN'],
            ['nome' => 'Moxico Leste', 'capital' => 'Cameia', 'codigo' => 'MLE'],
            ['nome' => 'Icolo e Bengo', 'capital' => 'Catete', 'codigo' => 'IBE'],
        ];

        DB::table('provincias')->insert($provincias);
    }
}