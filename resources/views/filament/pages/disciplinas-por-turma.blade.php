<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Seletor da Turma --}}
        <div class="bg-white rounded-lg shadow p-4 dark:bg-gray-800">
            {{ $this->form }}
        </div>

        @if($selectedTurma)
            <div class="mt-4 flex justify-end">
                <button wire:click="salvarDisciplinas" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">
                    Salvar Disciplinas
                </button>
            </div>
        @else
            <div class="bg-yellow-50 rounded-lg p-4 text-center dark:bg-yellow-900/20">
                <p class="text-yellow-800 dark:text-yellow-300">
                    Selecione uma turma para gerenciar as disciplinas.
                </p>
            </div>
        @endif
    </div>
</x-filament-panels::page>