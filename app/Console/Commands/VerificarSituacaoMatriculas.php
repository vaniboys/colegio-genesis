<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Matricula;

class VerificarSituacaoMatriculas extends Command
{
    protected $signature = 'matriculas:verificar-situacao';
    protected $description = 'Atualizar situação das matrículas com base nas propinas';

    public function handle()
    {
        $matriculas = Matricula::whereIn('situacao', ['ativa', 'pendente'])->get();
        
        foreach ($matriculas as $matricula) {
            $matricula->atualizarSituacao();
        }
        
        $this->info(' Situação das matrículas atualizada!');
    }
}