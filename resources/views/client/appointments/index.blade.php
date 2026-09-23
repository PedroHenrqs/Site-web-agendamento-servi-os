@extends('layouts.app')

@section('title', 'Meus Agendamentos - TechFix')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Meus agendamentos</h1>

    <div class="space-y-4">
        @forelse($appointments as $agendamento)
            <div class="bg-white border rounded-lg p-4 shadow-sm flex justify-between items-center gap-4">
                <div>
                    <p class="font-medium">{{ $agendamento->service->name }}</p>
                    <p class="text-sm text-slate-500">{{ $agendamento->date->format('d/m/Y') }} às {{ \Illuminate\Support\Carbon::parse($agendamento->time)->format('H:i') }} — {{ $agendamento->service->price_formatted }}</p>
                </div>
                @php
                    $badge = match($agendamento->status) {
                        'pendente' => 'bg-amber-100 text-amber-700',
                        'agendado' => 'bg-sky-100 text-sky-700',
                        'concluido' => 'bg-emerald-100 text-emerald-700',
                        'cancelado' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-700',
                    };
                @endphp
                <div class="flex items-center gap-3">
                    <span class="text-xs px-2 py-1 rounded {{ $badge }}">{{ $agendamento->statusLabel() }}</span>
                    @if(in_array($agendamento->status, ['pendente', 'agendado'], true))
                        <form method="POST" action="{{ route('client.appointments.cancel', $agendamento) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">Cancelar</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white border rounded-lg p-8 text-center shadow-sm">
                <p class="text-slate-500">Você ainda não realizou nenhum agendamento.</p>
                <a href="{{ route('client.services.index') }}" class="inline-block mt-4 bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-500">Ver serviços</a>
            </div>
        @endforelse
    </div>
@endsection
