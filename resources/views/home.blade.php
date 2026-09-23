@extends('layouts.app')

@section('title', 'Início - TechFix')

@section('content')
    <section class="text-center py-10">
        <h1 class="text-3xl font-bold text-slate-900">Assistência técnica sem complicação</h1>
        <p class="mt-3 text-slate-600 max-w-xl mx-auto">Agende formatação, manutenção, instalação de software e muito mais em poucos cliques.</p>
        <div class="mt-6 flex justify-center gap-3">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.services.index') }}" class="bg-sky-600 text-white px-5 py-2.5 rounded-md hover:bg-sky-500">Ver serviços</a>
            @else
                <a href="{{ route('register') }}" class="bg-sky-600 text-white px-5 py-2.5 rounded-md hover:bg-sky-500">Criar conta grátis</a>
                <a href="{{ route('login') }}" class="border border-slate-300 px-5 py-2.5 rounded-md hover:bg-slate-100">Entrar</a>
            @endauth
        </div>
    </section>

    @if($services->isNotEmpty())
        <section class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Alguns dos nossos serviços</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($services as $service)
                    <div class="border rounded-lg p-4 bg-white shadow-sm">
                        <h3 class="font-semibold">{{ $service->name }}</h3>
                        <p class="text-sm text-slate-500 mt-1">{{ \Illuminate\Support\Str::limit($service->description, 80) }}</p>
                        <p class="mt-2 font-medium text-sky-700">{{ $service->price_formatted }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection
