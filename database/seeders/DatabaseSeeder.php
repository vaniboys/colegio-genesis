<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BASE DO SISTEMA
        $this->call([
            AnoLectivoSeeder::class,
            NivelEnsinoSeeder::class,
            ProvinciaSeeder::class,
        ]);

        // 2. ESTRUTURA ESCOLAR
        $this->call([
            CursoSeeder::class,
            ClasseSeeder::class,
            DisciplinaSeeder::class,
        ]);

        // 3. TURMAS
        $this->call([
            TurmaSeeder::class,
        ]);

        // 4. PESSOAS
        $this->call([
            ProfessorSeeder::class,
            AlunoSeeder::class,           // Cria 650 alunos
            LivroPrimarioSeeder::class,   // Livros
            UserSeeder::class,            // Admin, Professores, Secretaria
            MatriculaSeeder::class,       // Matricula e cria contas
        ]);

        // 5. ROLES
        $this->createRolesAndAssign();
    }

    private function createRolesAndAssign(): void
    {
        // Criar roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $professorRole = Role::firstOrCreate(['name' => 'professor', 'guard_name' => 'web']);
        $alunoRole = Role::firstOrCreate(['name' => 'aluno', 'guard_name' => 'web']);
        $secretariaRole = Role::firstOrCreate(['name' => 'secretaria', 'guard_name' => 'web']);

        // Atribuir admin
        $admin = User::where('email', 'admin@escola.ao')->first();
        if ($admin && !$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        // Atribuir professor (primeiro professor)
        $professor = User::where('email', 'professor@escola.ao')->first();
        if ($professor && !$professor->hasRole('professor')) {
            $professor->assignRole($professorRole);
        }
    }
}