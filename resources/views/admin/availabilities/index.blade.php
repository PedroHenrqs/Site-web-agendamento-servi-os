@extends('layouts.app')

@section('title', 'Disponibilidade - Admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Horários disponíveis</h1>
        <a href="{{ route('admin.availabilities.create') }}" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-500">Novo horário</a>
    </div>

    @forelse($availabilities as $date => $slots)
        <div class="mb-4">
            <h2 class="font-semibold text-slate-700 mb-2">{{ \Illuminate\Support\Carbon::parse($date)->format('d/m/Y') }}</h2>
            <div class="bg-white border rounded-lg divide-y">
                @foreach($slots as $slot)
                    <div class="p-3 flex justify-between items-center text-sm">
                        <span>{{ \Illuminate\Support\Carbon::parse($slot->time)->format('H:i') }}</span>
                        <div class="flex items-center gap-3">
                            <span class="text-xs px-2 py-1 rounded {{ $slot->available ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $slot->available ? 'Disponível' : 'Ocupado' }}
                            </span>
                            @if($slot->available)
                                <form method="POST" action="{{ route('admin.availabilities.destroy', $slot) }}" onsubmit="return confirm('Remover este horário?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 underline">Remover</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-slate-400">Nenhum horário cadastrado.</p>
    @endforelse
@endsection
