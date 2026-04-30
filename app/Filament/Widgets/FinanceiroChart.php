<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class FinanceiroChart extends ChartWidget
{
    protected ?string $heading = 'Receita mensal';

    protected function getData(): array
    {
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = \App\Models\Pagamento::whereMonth('created_at', $i)->sum('valor');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Receita (Kz)',
                    'data' => $data,
                ],
            ],
            'labels' => ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}