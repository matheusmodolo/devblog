<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight w-1/3">
                Desenvolvedores
            </h2>

            {{-- Campo de Busca --}}
            <form action="{{ route('desenvolvedores.index') }}" method="GET" class="flex justify-end w-1/3">
                <x-text-input name="search" placeholder="Buscar desenvolvedor…" class="mr-4"
                    value="{{ request('search') }}" />
                <x-primary-button>Buscar</x-primary-button>
            </form>
            <div class="w-1/3 flex justify-end">
                <x-nav-link :href="route('desenvolvedores.create')" class="px-3 hover:border-transparent focus:border-transparent">
                    Novo
                </x-nav-link>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="space-y-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse ($desenvolvedores as $desenvolvedor)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center">

                        <!-- Foto -->
                        <img class="h-20 w-20 rounded-full" src="{{ asset('storage/' . $desenvolvedor->foto) }}"
                            alt="" />

                        <!-- Conteúdo textual -->
                        <div class="flex-1 ml-6">

                            <div class="flex justify-between items-start">
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-2 mb-2">
                                    <!-- Nome -->
                                    <h3 class="text-lg text-gray-800 dark:text-gray-200 leading-tight">
                                        {{ $desenvolvedor->nome }}
                                    </h3>
                                    <!-- Email -->
                                    <p class="text-md font-medium text-gray-400">
                                        {{ $desenvolvedor->email }}
                                    </p>
                                </div>

                                <!-- Botões -->
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('desenvolvedores.edit', $desenvolvedor) }}">
                                        <x-secondary-button class="px-3 py-2">
                                            Editar
                                        </x-secondary-button>
                                    </a>
                                    <form method="POST" action="{{ route('desenvolvedores.destroy', $desenvolvedor) }}"
                                        onsubmit="return confirmarExclusao(event)">
                                        @method('DELETE') @csrf
                                        <x-danger-button class="px-3 py-2">
                                            Excluir
                                        </x-danger-button>
                                    </form>
                                </div>

                            </div>

                            <!-- Biografia -->
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ $desenvolvedor->biografia }}
                            </p>

                        </div>
                    </div>
                </div>
                <!-- Caso não encontre nenhum desenvolvedor -->
            @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Ops! Nenhum desenvolvedor encontrado
                    </div>
                </div>
            @endforelse

            {{-- Paginação --}}
            <div class="mt-6">
                {{ $desenvolvedores->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
