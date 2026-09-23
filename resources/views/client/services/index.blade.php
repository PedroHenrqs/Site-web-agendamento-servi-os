@extends('layouts.app')

@section('title', 'Serviços - TechFix')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Nossos serviços</h1>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
        @forelse($services as $service)
            <div class="border rounded-lg p-4 bg-white shadow-sm flex flex-col justify-between">
                <div>
                    <h2 class="font-semibold">{{ $service->name }}</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ \Illuminate\Support\Str::limit($service->description, 90) }}</p>
                </div>
                <div class="mt-3 flex items-center justify-between">
                    <span class="font-medium text-sky-700">{{ $service->price_formatted }}</span>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('client.appointments.create', $service) }}" class="text-sm text-sky-600 underline">Ver detalhes</a>
                        <a href="{{ route('client.appointments.create', $service) }}" class="text-sm bg-sky-600 text-white px-3 py-1.5 rounded-md hover:bg-sky-500">Agendar</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-slate-400">Nenhum serviço disponível no momento.</p>
        @endforelse
    </div>
@endsection
