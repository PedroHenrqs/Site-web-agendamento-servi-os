@extends('layouts.app')

@section('title', 'Meu Painel - TechFix')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Meu painel</h1>

    <div class="grid sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white border rounded-lg p-4 shadow-sm">
            <p class="text-sm text-slate-500">Total de agendamentos</p>
            <p class="text-2xl font-semibold">{{ $totalAgendamentos }}</p>
        </div>
        <div class="bg-white border rounded-lg p-4 shadow-sm sm:col-span-2">
            <p class="text-sm text-slate-500">Próximo agendamento</p>
            @if($proximoAgendamento)
                <p class="font-medium">{{ $proximoAgendamento->service->name }} — {{ $proximoAgendamento->date->format('d/m/Y') }} às {{ \Illuminate\Support\Carbon::parse($proximoAgendamento->time)->format('H:i') }}</p>
                <span class="inline-block mt-1 text-xs px-2 py-1 rounded bg-amber-100 text-amber-700">{{ $proximoAgendamento->statusLabel() }}</span>
            @else
                <p class="text-slate-400">Nenhum agendamento futuro.</p>
            @endif
        </div>
    </div>

    <h2 class="font-semibold mb-3">Últimos agendamentos</h2>
    <div class="bg-white border rounded-lg divide-y">
        @forelse($ultimosAgendamentos as $agendamento)
            <div class="p-4 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $agendamento->service->name }}</p>
                    <p class="text-sm text-slate-500">{{ $agendamento->date->format('d/m/Y') }} às {{ \Illuminate\Support\Carbon::parse($agendamento->time)->format('H:i') }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded bg-slate-100">{{ $agendamento->statusLabel() }}</span>
            </div>
        @empty
            <p class="p-4 text-slate-400">Você ainda não possui agendamentos.</p>
        @endforelse
    </div>

    <a href="{{ route('client.services.index') }}" class="inline-block mt-6 bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-500">Agendar novo serviço</a>
@endsection
