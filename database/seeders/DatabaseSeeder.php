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
        ]);

        // 3. PESSOAS
        $this->call([
            ProfessorSeeder::class,
            AlunoSeeder::class,
            DisciplinaSeeder::class,
            TurmaSeeder::class,
            LivroPrimarioSeeder::class,
            UserSeeder::class,
        ]);

        // 4. ROLES + ATRIBUIÇÃO SEGURA
        $this->createRolesAndAssign();
    }

    private function createRolesAndAssign(): void
    {
        //  CRIAR ROLES (OBRIGATÓRIO)
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $profRole = Role::firstOrCreate([
            'name' => 'professor',
            'guard_name' => 'web',
        ]);

        $alunoRole = Role::firstOrCreate([
            'name' => 'aluno',
            'guard_name' => 'web',
        ]);

        // 🔥 ATRIBUIR ROLES POR EMAIL (SEGURO)
        $admin = User::where('email', 'admin@escola.ao')->first();
        if ($admin) {
            $admin->assignRole($adminRole);
        }

        $prof = User::where('email', 'professor@escola.ao')->first();
        if ($prof) {
            $prof->assignRole($profRole);
        }

        $aluno = User::where('email', 'aluno@escola.ao')->first();
        if ($aluno) {
            $aluno->assignRole($alunoRole);
        }
    }
}