{{-- resources/views/artigos/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $artigo->titulo }}
            </h2>
            <a href="{{ route('artigos.index') }}"
                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 transition">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Capa --}}
                @if ($artigo->foto_capa)
                    <img src="{{ asset('storage/' . $artigo->foto_capa) }}" alt="Capa de {{ $artigo->titulo }}"
                        class="w-full object-cover rounded-t-lg" style="height: 20rem;">
                @endif

                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    {{-- Título e Data --}}
                    <div>
                        <p class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">{{ $artigo->titulo }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Publicado em {{ \Carbon\Carbon::parse($artigo->data_publicacao)->format('d/m/Y') }}
                        </p>
                    </div>

                    {{-- Conteúdo Completo --}}
                    <div class="prose dark:prose-invert max-w-none py-4">
                        {!! nl2br(e($artigo->conteudo)) !!}
                    </div>

                    {{-- Desenvolvedores Vinculados --}}
                    @if ($artigo->desenvolvedores->count())
                        <div class="mt-4 border-t border-gray-200 dark:border-gray-600">
                            <h2 class="text-xl font-semibold mt-6">Desenvolvedores</h2>
                            <div class="mt-6 space-y-6">
                                @foreach ($artigo->desenvolvedores as $dev)
                                    <div class="flex items-start space-x-4">
                                        @if ($dev->foto)
                                            <img src="{{ asset('storage/' . $dev->foto) }}" alt="{{ $dev->nome }}"
                                                class="w-14 h-14 rounded-full object-cover">
                                        @endif
                                        <div>
                                            <div class="font-semibold text-gray-800 dark:text-gray-100">
                                                {{ $dev->nome }}
                                            </div>
                                            @if ($dev->email)
                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                    {{ $dev->email }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
