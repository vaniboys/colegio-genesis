<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackButton extends Component
{
    public $text;
    public $confirm;

    public function __construct($text = 'Voltar', $confirm = false)
    {
        $this->text = $text;
        $this->confirm = $confirm;
    }

    public function render(): View|Closure|string
    {
        return view('components.back-button');
    }
}