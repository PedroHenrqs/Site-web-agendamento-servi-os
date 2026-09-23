<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "TechFix Assistência Técnica")</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">
    <header class="bg-slate-900 text-white">
        <nav class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
            <a href="{{ route('home') }}" class="font-bold text-lg">TechFix</a>
            <div class="flex items-center gap-6 text-sm flex-wrap">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-sky-300">Painel Admin</a>
                        <a href="{{ route('admin.services.index') }}" class="hover:text-sky-300">Serviços</a>
                        <a href="{{ route('admin.appointments.index') }}" class="hover:text-sky-300">Agendamentos</a>
                        <a href="{{ route('admin.availabilities.index') }}" class="hover:text-sky-300">Disponibilidade</a>
                    @else
                        <a href="{{ route('client.dashboard') }}" class="hover:text-sky-300">Meu Painel</a>
                        <a href="{{ route('client.services.index') }}" class="hover:text-sky-300">Serviços</a>
                        <a href="{{ route('client.appointments.index') }}" class="hover:text-sky-300">Meus Agendamentos</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="hover:text-red-300">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-sky-300">Entrar</a>
                    <a href="{{ route('register') }}" class="bg-sky-500 px-3 py-1.5 rounded hover:bg-sky-400">Criar conta</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="flex-1 max-w-5xl w-full mx-auto px-4 py-8">
        @if(session("status"))
            <div class="mb-6 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                {{ session("status") }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield("content")
    </main>

    <footer class="text-center text-xs text-slate-400 py-6">
        TechFix Assistência Técnica &mdash; © 2026 TechFix
    </footer>
</body>
</html>
