<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Professor;
use App\Models\Aluno;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::create([
            'name' => 'Admin',
            'email' => 'admin@escola.ao',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);

        // PROFESSOR (SEGURANÇA FK)
        $professor = Professor::first();

        User::create([
            'name' => $professor->nome_completo,
            'email' => $professor->email,
            'password' => bcrypt('123456'),
            'role' => 'professor',
            'professor_id' => $professor->id,
        ]);

        // ALUNO
        $aluno = Aluno::first();

        User::create([
            'name' => $aluno->nome_completo,
            'email' => 'aluno@escola.ao',
            'password' => bcrypt('123456'),
            'role' => 'aluno',
            'aluno_id' => $aluno->id,
        ]);
    }
}