@extends('layouts.app')

@section('title', 'Meus Agendamentos - TechFix')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Meus agendamentos</h1>

    <div class="bg-white border rounded-lg divide-y">
        @forelse($appointments as $agendamento)
            <div class="p-4 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $agendamento->service->name }}</p>
                    <p class="text-sm text-slate-500">{{ $agendamento->date->format('d/m/Y') }} às {{ \Illuminate\Support\Carbon::parse($agendamento->time)->format('H:i') }} — {{ $agendamento->service->price_formatted }}</p>
                </div>
                @php
                    $badge = match($agendamento->status) {
                        'pendente' => 'bg-amber-100 text-amber-700',
                        'agendado' => 'bg-sky-100 text-sky-700',
                        'concluido' => 'bg-emerald-100 text-emerald-700',
                        default => 'bg-slate-100 text-slate-700',
                    };
                @endphp
                <span class="text-xs px-2 py-1 rounded {{ $badge }}">{{ $agendamento->statusLabel() }}</span>
            </div>
        @empty
            <p class="p-4 text-slate-400">Você ainda não realizou nenhum agendamento.</p>
        @endforelse
    </div>
@endsection
