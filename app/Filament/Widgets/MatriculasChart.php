<?php

namespace App\Filament\Widgets;

use App\Models\Matricula;
use Filament\Widgets\ChartWidget;

class MatriculasChart extends ChartWidget
{
    protected ?string $heading = 'Matrículas por mês';

    protected function getData(): array
    {
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = Matricula::whereMonth('created_at', $i)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Matrículas',
                    'data' => $data,
                ],
            ],
            'labels' => ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}