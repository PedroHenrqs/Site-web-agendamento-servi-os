@extends('layouts.app')

@section('title', 'Agendamentos - Admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Agendamentos</h1>

    <div class="bg-white border rounded-lg divide-y">
        @forelse($appointments as $agendamento)
            <div class="p-4 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $agendamento->service->name }} — {{ $agendamento->user->name }}</p>
                    <p class="text-sm text-slate-500">{{ $agendamento->date->format('d/m/Y') }} às {{ \Illuminate\Support\Carbon::parse($agendamento->time)->format('H:i') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs px-2 py-1 rounded bg-slate-100">{{ $agendamento->statusLabel() }}</span>
                    <a href="{{ route('admin.appointments.show', $agendamento) }}" class="text-sm text-sky-600 underline">Ver</a>
                </div>
            </div>
        @empty
            <p class="p-4 text-slate-400">Nenhum agendamento realizado ainda.</p>
        @endforelse
    </div>
@endsection
