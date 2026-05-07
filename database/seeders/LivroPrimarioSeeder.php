<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;
use App\Models\Disciplina;
use App\Models\Turma;
use App\Models\Classe;
use Illuminate\Support\Facades\Schema;

class LivroPrimarioSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📚 Criando biblioteca de livros...');
        $this->command->newLine();

        // Buscar disciplinas
        $disciplinas = Disciplina::get()->keyBy('codigo');
        
        // Buscar turmas
        $turmas = Turma::with('classe')->get();
        $turmasPorClasse = [];
        foreach ($turmas as $turma) {
            $classeNome = $turma->classe->nome;
            if (!isset($turmasPorClasse[$classeNome])) {
                $turmasPorClasse[$classeNome] = [];
            }
            $turmasPorClasse[$classeNome][] = $turma;
        }

        $livros = $this->getLivrosData();
        
        $count = 0;
        $errors = 0;

        foreach ($livros as $livroData) {
            // Buscar disciplina
            $disciplina = isset($disciplinas[$livroData['disciplina_codigo']]) 
                ? $disciplinas[$livroData['disciplina_codigo']] 
                : null;
            
            if (!$disciplina) {
                $this->command->warn("⚠️ Disciplina '{$livroData['disciplina_codigo']}' não encontrada. Livro '{$livroData['titulo']}' ignorado.");
                $errors++;
                continue;
            }
            
            // Buscar turma da classe correspondente
            $classeNome = $livroData['classe_nome'];
            $turma = null;
            
            if (isset($turmasPorClasse[$classeNome]) && !empty($turmasPorClasse[$classeNome])) {
                $turma = $turmasPorClasse[$classeNome][0]; // Pega a primeira turma da classe
            }
            
            if (!$turma) {
                $this->command->warn("⚠️ Nenhuma turma encontrada para a classe '{$classeNome}'. Livro '{$livroData['titulo']}' ignorado.");
                $errors++;
                continue;
            }
            
            // Criar ou atualizar livro
            Livro::updateOrCreate(
                [
                    'titulo' => $livroData['titulo'],
                    'disciplina_id' => $disciplina->id,
                ],
                [
                    'titulo' => $livroData['titulo'],
                    'autor' => $livroData['autor'],
                    'editora' => $livroData['editora'],
                    'isbn' => $livroData['isbn'] ?? null,
                    'disciplina_id' => $disciplina->id,
                    'turma_id' => $turma->id,
                    'ano_publicacao' => $livroData['ano_publicacao'],
                    'descricao' => $livroData['descricao'],
                    'capa' => $livroData['capa'] ?? null,
                    'arquivo_pdf' => $livroData['arquivo_pdf'] ?? null,
                    'visualizacoes' => 0,
                    'downloads' => 0,
                    'ativo' => true,
                ]
            );
            
            $count++;
            $this->command->line("   ✓ {$livroData['titulo']}");
        }

        $this->command->newLine();
        $this->command->info("══════════════════════════════════════════");
        $this->command->info("✅ {$count} livros criados/atualizados!");
        
        if ($errors > 0) {
            $this->command->warn("⚠️ {$errors} livros ignorados");
        }
        $this->command->info("══════════════════════════════════════════");
        
        // Estatísticas
        $this->command->newLine();
        $this->command->info("📊 ESTATÍSTICAS:");
        $this->command->line("   📚 Total de livros: " . Livro::count());
        $this->command->line("   📖 Por disciplina: " . Livro::distinct('disciplina_id')->count('disciplina_id'));
        $this->command->line("   🏫 Por turma: " . Livro::distinct('turma_id')->count('turma_id'));
    }
    
    private function getLivrosData(): array
    {
        return [
            // ==================== 1ª CLASSE ====================
            [
                'titulo' => 'Estudo Manual e Plástica - 1ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 1ª Classe.',
                'classe_nome' => '1ª Classe',
            ],
            [
                'titulo' => 'Matemática - 1ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 1ª Classe.',
                'classe_nome' => '1ª Classe',
            ],
            [
                'titulo' => 'Educação Musical - 1ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMU',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 1ª Classe.',
                'classe_nome' => '1ª Classe',
            ],
            [
                'titulo' => 'Estudo do Meio - 1ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EM',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 1ª Classe.',
                'classe_nome' => '1ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 1ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 1ª Classe.',
                'classe_nome' => '1ª Classe',
            ],
            
            // ==================== 2ª CLASSE ====================
            [
                'titulo' => 'Língua Portuguesa - 2ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 2ª Classe.',
                'classe_nome' => '2ª Classe',
            ],
            [
                'titulo' => 'Estudo do Meio - 2ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EM',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 2ª Classe.',
                'classe_nome' => '2ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 2ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 2ª Classe.',
                'classe_nome' => '2ª Classe',
            ],
            [
                'titulo' => 'Educação Musical - 2ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMU',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 2ª Classe.',
                'classe_nome' => '2ª Classe',
            ],
            [
                'titulo' => 'Matemática - 2ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 2ª Classe.',
                'classe_nome' => '2ª Classe',
            ],
            
            // ==================== 3ª CLASSE ====================
            [
                'titulo' => 'Educação Musical - 3ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMU',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 3ª Classe.',
                'classe_nome' => '3ª Classe',
            ],
            [
                'titulo' => 'Estudo do Meio - 3ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EM',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 3ª Classe.',
                'classe_nome' => '3ª Classe',
            ],
            [
                'titulo' => 'Matemática - 3ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 3ª Classe.',
                'classe_nome' => '3ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 3ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 3ª Classe.',
                'classe_nome' => '3ª Classe',
            ],
            
            // ==================== 4ª CLASSE ====================
            [
                'titulo' => 'Estudo do Meio - 4ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EM',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 4ª Classe.',
                'classe_nome' => '4ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 4ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 4ª Classe.',
                'classe_nome' => '4ª Classe',
            ],
            [
                'titulo' => 'Matemática - 4ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 4ª Classe.',
                'classe_nome' => '4ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 4ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 4ª Classe.',
                'classe_nome' => '4ª Classe',
            ],
            [
                'titulo' => 'Educação Musical - 4ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMU',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 4ª Classe.',
                'classe_nome' => '4ª Classe',
            ],
            
            // ==================== 5ª CLASSE ====================
            [
                'titulo' => 'Ciências da Natureza - 5ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'CN',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Ciências da Natureza para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Educação Moral e Cívica - 5ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMC',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Moral e Cívica para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Geografia - 5ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'GEO',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Geografia para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 5ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'História - 5ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'HIST',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de História para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Matemática - 5ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 5ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],
            
            // ==================== 6ª CLASSE ====================
            [
                'titulo' => 'Ciências da Natureza - 6ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'CN',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Ciências da Natureza para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Educação Moral e Cívica - 6ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMC',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Moral e Cívica para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 6ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'EMP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Geografia - 6ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'GEO',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Geografia para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'História - 6ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'HIST',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de História para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Matemática - 6ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 6ª Classe',
                'autor' => 'Equipa Xilonga',
                'editora' => 'Xilonga Editora',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
        ];
    }
}