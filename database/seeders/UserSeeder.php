<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Professor;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📝 Criando usuários do sistema...');
        $this->command->newLine();

        // ==================== 1. ADMIN ====================
        User::updateOrCreate(
            ['email' => 'admin@escola.ao'],
            [
                'name' => 'Administrador do Sistema',
                'email' => 'admin@escola.ao',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info("✅ Admin criado: admin@escola.ao / 123456");

        // ==================== 2. PROFESSORES ====================
        $professores = Professor::all();
        
        if ($professores->isEmpty()) {
            $this->command->warn("⚠️ Nenhum professor encontrado! Execute ProfessorSeeder primeiro.");
        } else {
            $profCount = 0;
            foreach ($professores as $professor) {
                User::updateOrCreate(
                    ['email' => $professor->email],
                    [
                        'name' => $professor->nome_completo,
                        'email' => $professor->email,
                        'password' => Hash::make('123456'),
                        'role' => 'professor',
                        'professor_id' => $professor->id,
                        'email_verified_at' => now(),
                    ]
                );
                $profCount++;
                $this->command->line("   ✓ Professor: {$professor->nome_completo} ({$professor->email})");
            }
            $this->command->info("✅ {$profCount} professores criados/atualizados! (Senha: 123456)");
        }

        // ==================== 3. SECRETARIA ====================
        User::updateOrCreate(
            ['email' => 'secretaria@escola.ao'],
            [
                'name' => 'Secretária Administrativa',
                'email' => 'secretaria@escola.ao',
                'password' => Hash::make('123456'),
                'role' => 'secretaria',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info("✅ Secretaria criada: secretaria@escola.ao / 123456");
        
        // ==================== NOTA SOBRE ALUNOS ====================
        $this->command->newLine();
        $this->command->info("🔄 NOTA: As contas dos alunos serão criadas automaticamente durante as matrículas!");
        $this->command->info("   → Login: Número de Processo");
        $this->command->info("   → Senha: Número de Processo");

        $this->command->newLine();
        $this->command->info("══════════════════════════════════════════");
        $this->command->info("📊 RESUMO DE USUÁRIOS:");
        $this->command->info("   Admin: " . User::where('role', 'admin')->count());
        $this->command->info("   Professores: " . User::where('role', 'professor')->count());
        $this->command->info("   Secretaria: " . User::where('role', 'secretaria')->count());
        $this->command->info("   Alunos: " . User::where('role', 'aluno')->count());
        $this->command->info("══════════════════════════════════════════");
    }
}