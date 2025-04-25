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
            // impede o envio automático do form
            event.preventDefault();

            // dispara o modal de confirmação
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


        (function() {
            const html = document.documentElement;
            const btn = document.getElementById('theme-toggle');
            const iconLight = document.getElementById('icon-light');
            const iconDark = document.getElementById('icon-dark');

            let theme = localStorage.getItem('theme');
            if (!theme) {
                theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            html.classList.toggle('dark', theme === 'dark');

            // Ajusta o ícone
            function updateIcon() {
                if (html.classList.contains('dark')) {
                    iconDark.classList.add('hidden');
                    iconLight.classList.remove('hidden');
                } else {
                    iconLight.classList.add('hidden');
                    iconDark.classList.remove('hidden');
                }
            }
            updateIcon();

            // No clique, alterna tema
            btn.addEventListener('click', () => {
                html.classList.toggle('dark');
                const newTheme = html.classList.contains('dark') ? 'dark' : 'light';
                localStorage.setItem('theme', newTheme);
                updateIcon();
            });
        })();
    </script>
</body>

</html>
