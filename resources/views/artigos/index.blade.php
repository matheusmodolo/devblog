<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight w-1/3">
                Artigos
            </h2>
            
            {{-- Campo de Busca --}}
            <form action="{{ route('artigos.index') }}" method="GET" class="flex justify-end w-1/3">
                <x-text-input name="search" placeholder="Buscar artigo…" class="mr-4" value="{{ request('search') }}" />
                <x-primary-button>Buscar</x-primary-button>
            </form>

            {{-- Se o usuario estiver autenticado e for admin, mostrar o link para criar novo --}}
            @auth
                @if (Auth::user()->is_admin)
                    <div class="w-1/3 flex justify-end">
                        {{-- link para criar novo desenvolvedor --}}
                        <x-nav-link :href="route('desenvolvedores.create')" class="px-3 hover:border-transparent focus:border-transparent">
                            Novo
                        </x-nav-link>
                    </div>
                @else
                    {{-- Caso nao seja admin, nao fazer nada --}}
                    <div class="w-1/3"></div>
                @endif
            @else
                {{-- Caso nao esteja autenticado, nao fazer nada --}}
                <div class="w-1/3"></div>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 space-y-6">
            @forelse($artigos as $artigo)
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col md:flex-row h-auto">
                    {{-- Capa --}}
                    @if ($artigo->foto_capa)
                        <div class="md:w-1/4">
                            <img src="{{ asset('storage/' . $artigo->foto_capa) }}" alt="Capa de {{ $artigo->titulo }}"
                                class="object-cover w-full h-48 md:h-full rounded-t-lg md:rounded-l-lg md:rounded-tr-none">
                        </div>
                    @endif

                    {{-- Conteúdo resumo --}}
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            {{-- Data de Publicação --}}
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Publicado em
                                {{-- Formata a data de publicação no formato 'dd de mmmm de aaaa' --}}
                                {{ \Carbon\Carbon::parse($artigo->data_publicacao)->locale('pt_BR')->isoFormat('d \d\e MMMM \d\e Y') }}
                            </p>

                            {{-- Título --}}
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                                {{ $artigo->titulo }}
                            </h2>

                            {{-- Trecho do Conteúdo (primeiros 300 caracteres) --}}
                            <p class="mt-2 text-gray-600 dark:text-gray-300">
                                {{ \Illuminate\Support\Str::limit(strip_tags($artigo->conteudo), 300) }}
                            </p>
                        </div>

                        {{-- Link para a página de detalhes --}}
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <a href="{{ route('artigos.show', $artigo->id) }}">
                                    <x-primary-button class="px-3 py-2">
                                        Ver mais
                                    </x-primary-button>
                                </a>
                            </div>
                            <div>
                                @auth
                                    @if (Auth::user()->is_admin)
                                        {{-- Botão para editar o artigo --}}
                                        <a href="{{ route('artigos.edit', $artigo) }}">
                                            <x-secondary-button class="px-3 py-2">
                                                Editar
                                            </x-secondary-button>
                                        </a>

                                        {{-- Botão para excluir o artigo --}}
                                        {{-- O botão de excluir tem um evento onsubmit global que é executado antes de submeter o formulário e 
                                         confirma se o usuário realmente deseja excluir o artigo --}}
                                        <form method="POST" action="{{ route('artigos.destroy', $artigo) }}"
                                            onsubmit="return confirmarExclusao(event)" class="inline-block">
                                            @method('DELETE') @csrf
                                            <x-danger-button class="px-3 py-2">
                                                Excluir
                                            </x-danger-button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Ops! Nenhum artigo encontrado.
                    </div>
                </div>
            @endforelse

            {{-- Paginação --}}
            <div class="mt-6">
                {{ $artigos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
