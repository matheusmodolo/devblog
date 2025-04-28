{{-- Verifica se está passando um desenvolvedor como parâmetro --}}
@if (isset($desenvolvedor->id))
    {{-- Formulário para atualizar um desenvolvedor existente --}}
    <form method="POST" action="{{ route('desenvolvedores.update', ['desenvolvedor' => $desenvolvedor->id]) }}"
        enctype="multipart/form-data" class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
        @csrf
        @method('PUT')
    @else
        {{-- Formulário para criar um novo desenvolvedor --}}
        <form method="POST" action="{{ route('desenvolvedores.store') }}" enctype="multipart/form-data"
            class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
            @csrf
@endif

{{-- Nome --}}
<div style="margin: 0;">
    <x-input-label for="nome" value="Nome" />
    <x-text-input id="nome" name="nome" type="text" value="{{ $desenvolvedor->nome ?? old('nome') }}"
        required autofocus class="mt-1 block w-full" />
    <x-input-error :messages="$errors->get('nome')" class="mt-2" />
</div>

{{-- E-mail --}}
<div>
    <x-input-label for="email" value="E-mail" />
    <x-text-input id="email" name="email" type="email" value="{{ $desenvolvedor->email ?? old('email') }}"
        required class="mt-1 block w-full" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

{{-- Foto --}}
<div>
    <x-input-label for="foto" value="Foto" />
    <input id="foto" name="foto" type="file" accept="image/*"
        class="mt-1 block text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-gray-100 file:text-gray-700
                                      hover:file:bg-gray-200
                                      hover:cursor-pointer" />
    <x-input-error :messages="$errors->get('foto')" class="mt-2" />
</div>

{{-- Biografia --}}
<div>
    <x-input-label for="biografia" value="Biografia" />
    <textarea id="biografia" name="biografia" rows="4"
        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $desenvolvedor->biografia ?? old('biografia') }}</textarea>
    <x-input-error :messages="$errors->get('biografia')" class="mt-2" />
</div>

{{-- Botões --}}
<div class="flex items-center justify-end gap-4">
    <a href="{{ route('desenvolvedores.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
        Voltar
    </a>

    <x-primary-button>
        Salvar
    </x-primary-button>
</div>
</form>
