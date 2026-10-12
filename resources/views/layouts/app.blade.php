<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <meta name="csrf-token" content="{{ csrf_token() }}">

          <title>{{ config('app.name', 'SGMO Industrial') }}</title>

          <!-- Tailwind CSS via CDN -->
          <script src="https://cdn.tailwindcss.com"></script>

          <!-- Alpine.js (Necessário para o menu dropdown do Breeze e Logout) -->
          <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
     </head>
    <body class="font-sans antialiased bg-slate-100 text-slate-800">
        <div class="min-h-screen">
            <!-- Barra de Navegação do Breeze -->
            @include('layouts.navigation')

            <!-- Conteúdo Principal -->
            <main class="container mx-auto mt-8 p-4">
                @if(session('success'))
                    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </body>
</html>
