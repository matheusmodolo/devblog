<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">
    @include('sweetalert2::index')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
        // Função global para confirmar exclusão
        function confirmarExclusao(event) {
            // Impede o envio automático do form
            event.preventDefault();

            // Dispara o modal de confirmação
            Swal.fire({
                title: 'Você tem certeza?',
                text: 'Esta ação não poderá ser desfeita.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Cancelar',
                showCloseButton: true,
                reverseButtons: true,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Se confirmou, prossegue enviando o form
                    event.target.submit();
                }
                // Se cancelou, não faz nada
            });

            // Garante que o form não seja enviado antes do usuário escolher
            return false;
        }

        // Função auto-invocada para alternar temas
        (function() {
            // Elemento HTML raiz
            const html = document.documentElement;
            // Botão para alterar o tema
            const btn = document.getElementById('theme-toggle');
            // Ícone do tema claro
            const iconLight = document.getElementById('icon-light');
            // Ícone do tema escuro
            const iconDark = document.getElementById('icon-dark');

            // Verifica se há um tema salvo no localStorage
            let theme = localStorage.getItem('theme');
            // Se não houver tema salvo, define com base na preferência do sistema
            if (!theme) {
                theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            // Aplica a classe 'dark' se o tema for escuro
            html.classList.toggle('dark', theme === 'dark');

            // Função para atualizar os ícones de tema
            function updateIcon() {
                if (html.classList.contains('dark')) {
                    // Esconde o ícone de tema escuro
                    iconDark.classList.add('hidden');
                    // Mostra o ícone de tema claro
                    iconLight.classList.remove('hidden');
                } else {
                    // Esconde o ícone de tema claro
                    iconLight.classList.add('hidden');
                    // Mostra o ícone de tema escuro
                    iconDark.classList.remove('hidden');
                }
            }
            updateIcon();

            // Adiciona um evento de clique ao botão para alternar o tema
            btn.addEventListener('click', () => {
                // Alterna a classe 'dark' no HTML
                html.classList.toggle('dark');
                // Define o novo tema
                const newTheme = html.classList.contains('dark') ? 'dark' : 'light';
                // Salva o novo tema no localStorage
                localStorage.setItem('theme', newTheme);
                updateIcon();
            });
        })();
    </script>
</body>

</html>
