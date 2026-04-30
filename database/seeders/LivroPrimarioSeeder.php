<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;
use App\Models\Disciplina;
use App\Models\Turma;
use App\Models\Classe;

class LivroPrimarioSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar disciplinas existentes
        $disciplinas = Disciplina::whereIn('codigo', ['LP', 'MAT', 'CN', 'EF', 'EA', 'EMC'])->get();
        
        // Mapear disciplinas por código
        $disciplinasMap = [];
        foreach ($disciplinas as $d) {
            $disciplinasMap[$d->codigo] = $d->id;
        }
        
        // Buscar classes do Ensino Primário (1ª a 6ª)
        $classes = Classe::where('nivel_ensino_id', 1)->get(); // nivel_ensino_id 1 = PRIM
        
        // Livros para cada classe
        $livros = [
            // ==================== 1ª CLASSE ====================
            [
                'titulo' => 'Matemática - 1ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-001-1',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 1ª Classe do Ensino Primário.',
                'classe_nome' => '1ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 1ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-001-2',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 1ª Classe do Ensino Primário.',
                'classe_nome' => '1ª Classe',
            ],
            [
                'titulo' => 'Estudo do Meio - 1ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-001-3',
                'disciplina_codigo' => 'CN',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 1ª Classe do Ensino Primário.',
                'classe_nome' => '1ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 1ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-001-4',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 1ª Classe.',
                'classe_nome' => '1ª Classe',
            ],
            [
                'titulo' => 'Educação Física - 1ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-001-5',
                'disciplina_codigo' => 'EF',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Física para a 1ª Classe.',
                'classe_nome' => '1ª Classe',
            ],
            [
                'titulo' => 'Educação Musical - 1ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-001-6',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 1ª Classe.',
                'classe_nome' => '1ª Classe',
            ],

            // ==================== 2ª CLASSE ====================
            [
                'titulo' => 'Matemática - 2ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-002-1',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 2ª Classe do Ensino Primário.',
                'classe_nome' => '2ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 2ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-002-2',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 2ª Classe do Ensino Primário.',
                'classe_nome' => '2ª Classe',
            ],
            [
                'titulo' => 'Estudo do Meio - 2ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-002-3',
                'disciplina_codigo' => 'CN',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 2ª Classe do Ensino Primário.',
                'classe_nome' => '2ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 2ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-002-4',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 2ª Classe.',
                'classe_nome' => '2ª Classe',
            ],
            [
                'titulo' => 'Educação Física - 2ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-002-5',
                'disciplina_codigo' => 'EF',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Física para a 2ª Classe.',
                'classe_nome' => '2ª Classe',
            ],
            [
                'titulo' => 'Educação Musical - 2ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-002-6',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 2ª Classe.',
                'classe_nome' => '2ª Classe',
            ],

            // ==================== 3ª CLASSE ====================
            [
                'titulo' => 'Matemática - 3ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-003-1',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 3ª Classe do Ensino Primário.',
                'classe_nome' => '3ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 3ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-003-2',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 3ª Classe do Ensino Primário.',
                'classe_nome' => '3ª Classe',
            ],
            [
                'titulo' => 'Estudo do Meio - 3ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-003-3',
                'disciplina_codigo' => 'CN',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 3ª Classe do Ensino Primário.',
                'classe_nome' => '3ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 3ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-003-4',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 3ª Classe.',
                'classe_nome' => '3ª Classe',
            ],
            [
                'titulo' => 'Educação Física - 3ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-003-5',
                'disciplina_codigo' => 'EF',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Física para a 3ª Classe.',
                'classe_nome' => '3ª Classe',
            ],
            [
                'titulo' => 'Educação Musical - 3ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-003-6',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 3ª Classe.',
                'classe_nome' => '3ª Classe',
            ],

            // ==================== 4ª CLASSE ====================
            [
                'titulo' => 'Matemática - 4ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-004-1',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 4ª Classe do Ensino Primário.',
                'classe_nome' => '4ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 4ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-004-2',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 4ª Classe do Ensino Primário.',
                'classe_nome' => '4ª Classe',
            ],
            [
                'titulo' => 'Estudo do Meio - 4ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-004-3',
                'disciplina_codigo' => 'CN',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 4ª Classe do Ensino Primário.',
                'classe_nome' => '4ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 4ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-004-4',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 4ª Classe.',
                'classe_nome' => '4ª Classe',
            ],
            [
                'titulo' => 'Educação Física - 4ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-004-5',
                'disciplina_codigo' => 'EF',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Física para a 4ª Classe.',
                'classe_nome' => '4ª Classe',
            ],
            [
                'titulo' => 'Educação Musical - 4ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-004-6',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 4ª Classe.',
                'classe_nome' => '4ª Classe',
            ],

            // ==================== 5ª CLASSE ====================
            [
                'titulo' => 'Matemática - 5ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-005-1',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 5ª Classe do Ensino Primário.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 5ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-005-2',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 5ª Classe do Ensino Primário.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Estudo do Meio - 5ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-005-3',
                'disciplina_codigo' => 'CN',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 5ª Classe do Ensino Primário.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 5ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-005-4',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Educação Física - 5ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-005-5',
                'disciplina_codigo' => 'EF',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Física para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],
            [
                'titulo' => 'Educação Musical - 5ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-005-6',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 5ª Classe.',
                'classe_nome' => '5ª Classe',
            ],

            // ==================== 6ª CLASSE ====================
            [
                'titulo' => 'Matemática - 6ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-006-1',
                'disciplina_codigo' => 'MAT',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Matemática para a 6ª Classe do Ensino Primário.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Língua Portuguesa - 6ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-006-2',
                'disciplina_codigo' => 'LP',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Língua Portuguesa para a 6ª Classe do Ensino Primário.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Estudo do Meio - 6ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-006-3',
                'disciplina_codigo' => 'CN',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Estudo do Meio para a 6ª Classe do Ensino Primário.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Educação Manual e Plástica - 6ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-006-4',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Manual e Plástica para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Educação Física - 6ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-006-5',
                'disciplina_codigo' => 'EF',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Física para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
            [
                'titulo' => 'Educação Musical - 6ª Classe',
                'autor' => 'Equipa INADE',
                'editora' => 'INADE',
                'isbn' => '978-989-1-006-6',
                'disciplina_codigo' => 'EA',
                'ano_publicacao' => 2024,
                'descricao' => 'Manual de Educação Musical para a 6ª Classe.',
                'classe_nome' => '6ª Classe',
            ],
        ];

        $count = 0;
        $errors = 0;

        foreach ($livros as $livro) {
            // Buscar a classe
            $classe = $classes->firstWhere('nome', $livro['classe_nome']);
            
            if (!$classe) {
                $this->command->warn("⚠️ Classe '{$livro['classe_nome']}' não encontrada. Livro '{$livro['titulo']}' ignorado.");
                $errors++;
                continue;
            }
            
            // Buscar a disciplina
            $disciplinaId = $disciplinasMap[$livro['disciplina_codigo']] ?? null;
            
            if (!$disciplinaId) {
                $this->command->warn("⚠️ Disciplina '{$livro['disciplina_codigo']}' não encontrada. Livro '{$livro['titulo']}' ignorado.");
                $errors++;
                continue;
            }
            
            // Criar ou atualizar livro
            Livro::updateOrCreate(
                [
                    'titulo' => $livro['titulo'],
                    'disciplina_id' => $disciplinaId,
                ],
                [
                    'autor' => $livro['autor'],
                    'editora' => $livro['editora'],
                    'isbn' => $livro['isbn'],
                    'disciplina_id' => $disciplinaId,
                    'ano_publicacao' => $livro['ano_publicacao'],
                    'descricao' => $livro['descricao'],
                    'ativo' => true,
                ]
            );
            $count++;
        }

        $this->command->newLine();
        $this->command->info("✅ {$count} livros criados/atualizados para o Ensino Primário!");
        
        if ($errors > 0) {
            $this->command->warn("⚠️ {$errors} livros ignorados (classe ou disciplina não encontrada)");
        }
        
        // Resumo por classe
        $this->command->newLine();
        $this->command->info("📊 RESUMO POR CLASSE:");
        foreach ($classes as $classe) {
            $total = Livro::whereHas('disciplina', function($q) use ($classe) {
                $q->whereHas('classes', function($qc) use ($classe) {
                    $qc->where('classe_id', $classe->id);
                });
            })->count();
            $this->command->line("   {$classe->nome}: {$total} livros");
        }
    }
}