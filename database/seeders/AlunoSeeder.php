<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aluno;
use App\Models\Provincia;
use App\Models\Encarregado;

class AlunoSeeder extends Seeder
{
    public static $alunosPorClasse = []; // Para ser usado no MatriculaSeeder

    public function run(): void
    {
        $this->command->info('📚 Criando alunos da 1ª à 13ª classe...');
        $this->command->newLine();

        $provincia = Provincia::first();

        if (!$provincia) {
            $this->command->warn('⚠️ Nenhuma província encontrada!');
            return;
        }

        $encarregado = Encarregado::first();

        // Nomes angolanos
        $primeirosNomesM = ['João', 'José', 'António', 'Manuel', 'Francisco', 'Carlos', 'Paulo', 'Pedro', 'Luis', 'Augusto', 'Domingos', 'Felipe', 'Mário', 'Rui', 'Joaquim', 'André', 'Ricardo', 'Bruno', 'Rafael', 'Gabriel', 'Lucas', 'Matheus', 'Vitor', 'Eduardo', 'Miguel'];
        $primeirosNomesF = ['Maria', 'Ana', 'Paula', 'Fernanda', 'Teresa', 'Helena', 'Isabel', 'Rosa', 'Carla', 'Marta', 'Sofia', 'Beatriz', 'Larissa', 'Amanda', 'Patrícia', 'Daniela', 'Carolina', 'Juliana', 'Vanessa', 'Tatiana', 'Cristina', 'Angélica', 'Lúcia', 'Margarida'];
        $sobrenomes = ['Santos', 'Silva', 'Ferreira', 'Costa', 'Oliveira', 'Pereira', 'Rodrigues', 'Almeida', 'Martins', 'Fernandes', 'Gomes', 'Carvalho', 'Dias', 'Soares', 'Nunes', 'Lima', 'Barbosa', 'Ribeiro', 'Mendes', 'Monteiro', 'Ramos'];
        $municipios = ['Luanda', 'Cacuaco', 'Viana', 'Cazenga', 'Belas', 'Talatona', 'Kilamba Kiaxi', 'Ingombota', 'Maianga', 'Rangel', 'Samba', 'Sambizanga'];

        // ==================== DISTRIBUIÇÃO POR CLASSE ====================
        $classes = [
            '1ª Classe', '2ª Classe', '3ª Classe', '4ª Classe', '5ª Classe', '6ª Classe',
            '7ª Classe', '8ª Classe', '9ª Classe', '10ª Classe', '11ª Classe', '12ª Classe', '13ª Classe'
        ];
        
        // 50 alunos por classe (total 650 alunos)
        $alunosPorClasse = 50;
        $totalAlunos = count($classes) * $alunosPorClasse;
        
        $this->command->info("📊 Distribuição:");
        $this->command->line("   → " . count($classes) . " classes");
        $this->command->line("   → {$alunosPorClasse} alunos por classe");
        $this->command->line("   → Total: {$totalAlunos} alunos");
        $this->command->newLine();
        
        $this->command->info("⏳ Gerando {$totalAlunos} alunos...");
        
        $bar = $this->command->getOutput()->createProgressBar($totalAlunos);
        $bar->start();
        
        $processoCounter = 2600001;
        
        foreach ($classes as $classeNome) {
            self::$alunosPorClasse[$classeNome] = [];
            
            for ($i = 1; $i <= $alunosPorClasse; $i++) {
                $sexo = $i % 2 == 0 ? 'M' : 'F';
                $primeirosNomes = $sexo === 'M' ? $primeirosNomesM : $primeirosNomesF;
                
                $primeiroNome = $primeirosNomes[array_rand($primeirosNomes)];
                $sobrenome = $sobrenomes[array_rand($sobrenomes)];
                $nomeCompleto = $primeiroNome . ' ' . $sobrenome;
                
                // Data de nascimento baseada na classe
                $classeNum = (int) filter_var($classeNome, FILTER_SANITIZE_NUMBER_INT);
                $anoNascimento = 2025 - ($classeNum + 5);
                $dataNascimento = $anoNascimento . '-' . sprintf('%02d', rand(1, 12)) . '-' . sprintf('%02d', rand(1, 28));
                
                $bi = $this->gerarBIUnico($processoCounter);
                $telefone = '9' . rand(10000000, 99999999);
                $email = strtolower($primeiroNome . '.' . $sobrenome . $processoCounter . '@aluno.com');
                $processo = (string) $processoCounter;
                
                $aluno = Aluno::updateOrCreate(
                    ['processo' => $processo],
                    [
                        'processo' => $processo,
                        'nome_completo' => $nomeCompleto,
                        'sexo' => $sexo,
                        'data_nascimento' => $dataNascimento,
                        'provincia_id' => $provincia->id,
                        'municipio' => $municipios[array_rand($municipios)],
                        'endereco' => $this->gerarEndereco(),
                        'bi' => $bi,
                        'telefone' => $telefone,
                        'email' => $email,
                        'encarregado_id' => $encarregado?->id,
                        'foto' => null,
                        'situacao' => 'inactivo',
                    ]
                );
                
                self::$alunosPorClasse[$classeNome][] = $aluno;
                $processoCounter++;
                $bar->advance();
            }
        }
        
        $bar->finish();
        $this->command->newLine();
        $this->command->newLine();
        $this->command->info("═══════════════════════════════════════════════════════════");
        $this->command->info("✅ {$totalAlunos} alunos criados!");
        $this->command->info("═══════════════════════════════════════════════════════════");
        
        // Estatísticas
        $this->command->newLine();
        $this->command->info("📊 ESTATÍSTICAS:");
        $this->command->line("   📚 Total de alunos: " . Aluno::count());
        $this->command->line("   👨 Masculinos: " . Aluno::where('sexo', 'M')->count());
        $this->command->line("   👩 Femininos: " . Aluno::where('sexo', 'F')->count());
        
        // Distribuição por classe
        $this->command->newLine();
        $this->command->info("📊 DISTRIBUIÇÃO POR CLASSE:");
        foreach (self::$alunosPorClasse as $classeNome => $alunos) {
            $this->command->line("   📚 {$classeNome}: " . count($alunos) . " alunos");
        }
        
        // Faixa de processos
        $this->command->newLine();
        $this->command->info("📋 FAIXA DE PROCESSOS:");
        $primeiroProcesso = Aluno::orderBy('processo')->first()?->processo ?? 'N/A';
        $ultimoProcesso = Aluno::orderBy('processo', 'desc')->first()?->processo ?? 'N/A';
        $this->command->line("   → {$primeiroProcesso} até {$ultimoProcesso}");
    }
    
    private function gerarBIUnico(int $seed): string
    {
        $numeros = str_pad($seed % 99999999, 8, '0', STR_PAD_LEFT);
        $letras = ['LA', 'BG', 'HU', 'LU', 'CA', 'MA'];
        return $numeros . $letras[array_rand($letras)] . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
    }
    
    private function gerarEndereco(): string
    {
        $ruas = ['Rua', 'Avenida', 'Travessa', 'Bairro'];
        $nomes = ['Principal', 'Independência', 'Revolução', 'Liberdade', 'Popular', 'Nova Esperança'];
        return $ruas[array_rand($ruas)] . ' ' . $nomes[array_rand($nomes)] . ', Nº ' . rand(1, 200);
    }
}