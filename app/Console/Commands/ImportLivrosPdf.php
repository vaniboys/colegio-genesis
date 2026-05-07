<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Livro;
use App\Models\Classe;
use Illuminate\Support\Facades\Storage;

class ImportLivrosPdf extends Command
{
    protected $signature = 'livros:import-pdf';
    protected $description = 'Importar arquivos PDF dos livros para o banco de dados';

    public function handle()
    {
        $this->info('📚 Iniciando importação dos PDFs...');
        $this->newLine();
        
        $classes = Classe::where('nivel_ensino_id', 1)->get();
        $totalAtualizados = 0;
        $totalNaoEncontrados = 0;
        
        foreach ($classes as $classe) {
            $classeSlug = $this->getClasseSlug($classe->nome);
            $pastaPdf = storage_path("app/public/livros/{$classeSlug}");
            
            if (!is_dir($pastaPdf)) {
                $this->warn("⚠️ Pasta não encontrada: {$classeSlug}");
                continue;
            }
            
            $arquivos = glob($pastaPdf . '/*.pdf');
            
            foreach ($arquivos as $arquivo) {
                $nomeArquivo = basename($arquivo);
                $nomeSemExtensao = pathinfo($nomeArquivo, PATHINFO_FILENAME);
                
                // Tentar encontrar o livro pelo nome
                $livro = $this->findLivroByNome($nomeSemExtensao, $classe->id);
                
                if ($livro) {
                    $caminhoRelativo = "livros/{$classeSlug}/{$nomeArquivo}";
                    
                    // Verificar se já está associado
                    if ($livro->arquivo_pdf !== $caminhoRelativo) {
                        $livro->update(['arquivo_pdf' => $caminhoRelativo]);
                        $this->info("✅ Atualizado: {$livro->titulo}");
                        $totalAtualizados++;
                    } else {
                        $this->line("⏭️  Já existia: {$livro->titulo}");
                    }
                } else {
                    $this->warn("⚠️ Livro não encontrado para: {$nomeSemExtensao}");
                    $totalNaoEncontrados++;
                }
            }
        }
        
        $this->newLine();
        $this->info("══════════════════════════════════════════");
        $this->info("✅ {$totalAtualizados} livros atualizados com PDF!");
        if ($totalNaoEncontrados > 0) {
            $this->warn("⚠️ {$totalNaoEncontrados} arquivos não encontrados");
        }
        $this->info("══════════════════════════════════════════");
    }
    
    private function getClasseSlug($classe)
    {
        $map = [
            '1ª Classe' => '1a-classe',
            '2ª Classe' => '2a-classe',
            '3ª Classe' => '3a-classe',
            '4ª Classe' => '4a-classe',
            '5ª Classe' => '5a-classe',
            '6ª Classe' => '6a-classe',
        ];
        return $map[$classe] ?? strtolower(str_replace('ª', 'a', $classe));
    }
    
    private function findLivroByNome($nomeArquivo, $classeId)
    {
        // Mapeamento de nomes de arquivo para títulos
        $map = [
            'matematica' => 'Matemática',
            'lingua_portuguesa' => 'Língua Portuguesa',
            'estudo_do_meio' => 'Estudo do Meio',
            'educacao_musical' => 'Educação Musical',
            'educacao_manual_e_plastica' => 'Educação Manual e Plástica',
            'ciencias_da_natureza' => 'Ciências da Natureza',
            'geografia' => 'Geografia',
            'historia' => 'História',
            'educacao_moral_e_civica' => 'Educação Moral e Cívica',
        ];
        
        // Extrair disciplina do nome do arquivo
        $disciplinaNome = null;
        foreach ($map as $key => $nome) {
            if (str_contains($nomeArquivo, $key)) {
                $disciplinaNome = $nome;
                break;
            }
        }
        
        if (!$disciplinaNome) {
            return null;
        }
        
        // Buscar o livro
        return Livro::whereHas('disciplina', function($q) use ($disciplinaNome) {
            $q->where('nome', $disciplinaNome);
        })->whereHas('classes', function($q) use ($classeId) {
            $q->where('classe_id', $classeId);
        })->first();
    }
}