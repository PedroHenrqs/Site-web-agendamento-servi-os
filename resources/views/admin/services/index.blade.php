@extends('layouts.app')

@section('title', 'Serviços - Admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Serviços</h1>
        <a href="{{ route('admin.services.create') }}" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-500">Novo serviço</a>
    </div>

    <div class="bg-white border rounded-lg divide-y">
        @forelse($services as $service)
            <div class="p-4 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $service->name }}
                        @unless($service->active)
                            <span class="text-xs px-2 py-0.5 rounded bg-slate-200 text-slate-600 ml-2">Inativo</span>
                        @endunless
                    </p>
                    <p class="text-sm text-slate-500">{{ $service->price_formatted }}</p>
                </div>
                <div class="flex gap-3 text-sm">
                    <a href="{{ route('admin.services.edit', $service) }}" class="text-sky-600 underline">Editar</a>
                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Confirma a remoção/desativação deste serviço?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 underline">Remover</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="p-4 text-slate-400">Nenhum serviço cadastrado.</p>
        @endforelse
    </div>
@endsection
