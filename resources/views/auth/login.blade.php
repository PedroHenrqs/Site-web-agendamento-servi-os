@extends('layouts.app')

@section('title', 'Entrar - TechFix')

@section('content')
    <div class="max-w-sm mx-auto bg-white border rounded-lg p-6 shadow-sm">
        <h1 class="text-xl font-semibold mb-4">Entrar</h1>
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full border rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Senha</label>
                <input type="password" name="password" required class="w-full border rounded-md px-3 py-2">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Lembrar-me
            </label>
            <button type="submit" class="w-full bg-sky-600 text-white py-2 rounded-md hover:bg-sky-500">Entrar</button>
        </form>
        <p class="text-sm text-slate-500 mt-4">Não tem conta? <a href="{{ route('register') }}" class="text-sky-600 underline">Cadastre-se</a></p>
        <p class="text-xs text-slate-400 mt-4">Admin de teste: admin@example.com / admin123</p>
    </div>
@endsection
