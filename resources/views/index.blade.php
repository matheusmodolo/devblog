<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            DevBlog
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 space-y-6">
            @forelse($artigos as $artigo)
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col md:flex-row md:h-48 h-auto">
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
                                Publicado em {{ \Carbon\Carbon::parse($artigo->data_publicacao)->locale('pt_BR')->isoFormat('d \d\e MMMM \d\e Y') }}
                            </p>

                            {{-- Título --}}
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                                {{ $artigo->titulo }}
                            </h2>

                            {{-- Trecho do Conteúdo (primeiros 50 caracteres) --}}
                            <p class="mt-2 text-gray-600 dark:text-gray-300">
                                {{ \Illuminate\Support\Str::limit(strip_tags($artigo->conteudo), 50) }}
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

            {{-- Paginação, se você estiver usando paginate() --}}
            <div class="mt-6">
                {{ $artigos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
