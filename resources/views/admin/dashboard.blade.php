@extends('layouts.app')

@section('title', 'Painel Admin - TechFix')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Painel administrativo</h1>

    <div class="grid sm:grid-cols-3 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white border rounded-lg p-4 shadow-sm">
            <p class="text-sm text-slate-500">Clientes</p>
            <p class="text-2xl font-semibold">{{ $totalClientes }}</p>
        </div>
        <div class="bg-white border rounded-lg p-4 shadow-sm">
            <p class="text-sm text-slate-500">Serviços</p>
            <p class="text-2xl font-semibold">{{ $totalServicos }}</p>
        </div>
        <div class="bg-white border rounded-lg p-4 shadow-sm">
            <p class="text-sm text-slate-500">Agendamentos</p>
            <p class="text-2xl font-semibold">{{ $totalAgendamentos }}</p>
        </div>
        <div class="bg-white border rounded-lg p-4 shadow-sm">
            <p class="text-sm text-slate-500">Pendentes</p>
            <p class="text-2xl font-semibold">{{ $agendamentosPendentes }}</p>
        </div>
        <div class="bg-white border rounded-lg p-4 shadow-sm">
            <p class="text-sm text-slate-500">Concluídos</p>
            <p class="text-2xl font-semibold">{{ $agendamentosConcluidos }}</p>
        </div>
    </div>

    <h2 class="font-semibold mb-3">Próximos atendimentos</h2>
    <div class="bg-white border rounded-lg divide-y">
        @forelse($proximosAtendimentos as $agendamento)
            <div class="p-4 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $agendamento->service->name }} — {{ $agendamento->user->name }}</p>
                    <p class="text-sm text-slate-500">{{ $agendamento->date->format('d/m/Y') }} às {{ \Illuminate\Support\Carbon::parse($agendamento->time)->format('H:i') }}</p>
                </div>
                <a href="{{ route('admin.appointments.show', $agendamento) }}" class="text-sm text-sky-600 underline">Ver</a>
            </div>
        @empty
            <p class="p-4 text-slate-400">Nenhum atendimento futuro.</p>
        @endforelse
    </div>
@endsection
