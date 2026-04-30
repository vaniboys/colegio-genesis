<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\NivelEnsino;
use App\Models\Classe;

class ClasseSeeder extends Seeder
{
    public function run(): void
    {
        // Desabilitar verificação de chaves estrangeiras
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Limpar classes existentes
        Classe::query()->delete();
        
        // Habilitar verificação de chaves estrangeiras
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $niveis = NivelEnsino::all();

        foreach ($niveis as $nivel) {
            $temCurso = in_array($nivel->codigo, ['SEC2', 'SEC2_T']);

            for ($i = $nivel->classe_inicio; $i <= $nivel->classe_fim; $i++) {
                Classe::create([
                    'nome' => $i . 'ª Classe',
                    'nivel_ensino_id' => $nivel->id,
                    'tem_curso' => $temCurso,
                ]);
            }
        }
        
        $total = Classe::count();
        $comCurso = Classe::where('tem_curso', true)->count();
        $semCurso = Classe::where('tem_curso', false)->count();
        
        $this->command->info("✅ {$total} classes criadas!");
        $this->command->info("   Com curso (10ª-13ª): {$comCurso}");
        $this->command->info("   Sem curso (1ª-9ª): {$semCurso}");
    }
}