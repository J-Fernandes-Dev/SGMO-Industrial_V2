<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGMO-Industrial - Gestão de Máquinas</title>
    <!-- Tailwind CSS via CDN para desenvolvimento -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans">

    <!-- Navegação Superior -->
    <nav class="bg-slate-900 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('machines.index') }}" class="font-bold text-xl tracking-wide text-blue-400">
                SGMO <span class="text-white text-sm font-normal">| Chão de Fábrica</span>
            </a>
            <div class="space-x-4">
                <a href="{{ route('machines.index') }}" class="hover:text-blue-300">Parque de Máquinas</a>
                <a href="{{ route('machines.create') }}" class="bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded font-medium text-sm">+ Nova Máquina</a>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="container mx-auto mt-8 p-4">
        <!-- Mensagens de Sucesso -->
        @if(session('success'))
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
