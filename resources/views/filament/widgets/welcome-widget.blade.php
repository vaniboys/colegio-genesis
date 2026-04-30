<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-6 bg-white rounded-xl shadow-sm border">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Bem-vindo, {{ auth()->user()->name }}!
        </h1>

        <p class="text-gray-500 mt-1">
            Resumo do sistema - {{ now()->format('d/m/Y') }}
        </p>
    </div>
</div>
    </x-filament::section>
</x-filament-widgets::widget>
