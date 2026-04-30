<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use App\Services\DistribuicaoProfessorService;
use BackedEnum;

class AdminDashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Painel Principal';
    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            \Filament\Widgets\AccountWidget::class,
            \App\Filament\Widgets\StatsOverview::class,
            \App\Filament\Widgets\MatriculasChart::class,
            \App\Filament\Widgets\AlertasWidget::class,
            \App\Filament\Widgets\AcoesRapidas::class,
        ];
    }

    //  Botão de Distribuição Automática
    protected function getHeaderActions(): array
    {
        return [
            Action::make('distribuir_professores')
                ->label('Distribuir Professores')
                ->icon('heroicon-o-cpu-chip')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Distribuição Automática de Professores')
                ->modalDescription('Isto vai atribuir automaticamente professores às turmas com base nas disciplinas, carga horária e disponibilidade. Deseja continuar?')
                ->modalSubmitActionLabel('Sim, distribuir')
                ->action(function () {
                    $servico = app(DistribuicaoProfessorService::class);
                    $resultado = $servico->distribuir(1); // Ano lectivo ID 1

                    if ($resultado['atribuicoes'] > 0) {
                        \Filament\Notifications\Notification::make()
                            ->title(' Distribuição concluída!')
                            ->body("{$resultado['atribuicoes']} professores atribuídos com sucesso.")
                            ->success()
                            ->send();
                    } else {
                        \Filament\Notifications\Notification::make()
                            ->title(' Nenhuma atribuição realizada')
                            ->body('Verifique se há professores disponíveis com disciplinas cadastradas.')
                            ->warning()
                            ->send();
                    }
                }),

            Action::make('resetar_carga')
                ->label('Resetar Carga')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Resetar Carga Horária')
                ->modalDescription('Isto vai zerar a carga atual de todos os professores. Deseja continuar?')
                ->action(function () {
                    app(DistribuicaoProfessorService::class)->resetarCarga();
                    \Filament\Notifications\Notification::make()
                        ->title('Carga resetada!')
                        ->success()
                        ->send();
                }),
        ];
    }
}