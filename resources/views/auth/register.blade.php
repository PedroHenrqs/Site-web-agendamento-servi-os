@extends('layouts.app')

@section('title', 'Criar conta - TechFix')

@section('content')
    <div class="max-w-sm mx-auto bg-white border rounded-lg p-6 shadow-sm">
        <h1 class="text-xl font-semibold mb-4">Criar conta</h1>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Nome</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full border rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Senha</label>
                <input type="password" name="password" required class="w-full border rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Confirmar senha</label>
                <input type="password" name="password_confirmation" required class="w-full border rounded-md px-3 py-2">
            </div>
            <button type="submit" class="w-full bg-sky-600 text-white py-2 rounded-md hover:bg-sky-500">Criar conta</button>
        </form>
        <p class="text-sm text-slate-500 mt-4">Já tem conta? <a href="{{ route('login') }}" class="text-sky-600 underline">Entrar</a></p>
    </div>
@endsection
