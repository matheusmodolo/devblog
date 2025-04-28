{{-- Verifica se está passando um artigo como parâmetro --}}
@if (isset($artigo->id))
    {{-- Formulário para atualizar um artigo existente --}}
    <form method="POST" action="{{ route('artigos.update', ['artigo' => $artigo->id]) }}" enctype="multipart/form-data"
        class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
        @csrf
        @method('PUT')
    @else
        {{-- Formulário para criar um novo artigo --}}
        <form method="POST" action="{{ route('artigos.store') }}" enctype="multipart/form-data"
            class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
            @csrf
@endif

{{-- Foto --}}
<div style="margin: 0;">
    <x-input-label for="foto_capa" value="Foto de Capa" />
    <input id="foto_capa" name="foto_capa" type="file" accept="image/*"
        class="mt-1 block text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-gray-100 file:text-gray-700
                                      hover:file:bg-gray-200
                                      hover:cursor-pointer" />
    <x-input-error :messages="$errors->get('foto_capa')" class="mt-2" />
</div>

{{-- Título --}}
<div>
    <x-input-label for="titulo" value="Título" />
    <x-text-input id="titulo" name="titulo" type="text" value="{{ $artigo->titulo ?? old('titulo') }}" required
        autofocus class="mt-1 block w-full" />
    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
</div>

{{-- Conteúdo --}}
<div>
    <x-input-label for="conteudo" value="Conteúdo" />
    <textarea id="conteudo" name="conteudo" rows="4"
        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $artigo->conteudo ?? old('conteudo') }}</textarea>
    <x-input-error :messages="$errors->get('conteudo')" class="mt-2" />
</div>

{{-- Desenvolvedores --}}
<div>
    <x-input-label for="desenvolvedores" value="Desenvolvedores" />
    <div class="mt-2 space-y-2 overflow-y-auto max-h-40">
        @foreach ($desenvolvedores as $dev)
            <label for="dev-{{ $dev->id }}" class="flex items-center">
                <input id="dev-{{ $dev->id }}" name="desenvolvedores[]" type="checkbox" value="{{ $dev->id }}"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 "
                    {{ in_array($dev->id, $artigo->desenvolvedores()->get()->pluck('id')->toArray() ?? old('desenvolvedores', [])) ? 'checked' : '' }} />
                <span class="ml-2 text-gray-600 dark:text-gray-500">{{ $dev->nome }}</span>
            </label>
        @endforeach
    </div>
    <x-input-error :messages="$errors->get('desenvolvedores')" class="mt-2" />
</div>

{{-- Botões --}}
<div class="flex items-center justify-end gap-4">
    <a href="{{ route('artigos.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
        Voltar
    </a>

    <x-primary-button>
        @if (isset($artigo->id))
            Salvar
        @else
            Publicar
        @endif
    </x-primary-button>
</div>
</form>
