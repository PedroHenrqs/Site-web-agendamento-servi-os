@extends('layouts.app')

@section('title', 'Agendar - TechFix')

@section('content')
    <div class="max-w-lg mx-auto">
        <a href="{{ route('client.services.index') }}" class="inline-block mb-4 text-sm text-sky-700 hover:text-sky-500">&larr; Voltar para Serviços</a>

        <div class="max-w-lg mx-auto shadow-sm border rounded-xl p-6 bg-white">
            <h1 class="text-2xl font-bold">{{ $service->name }}</h1>
            <p class="mt-3 text-slate-600">{{ $service->description }}</p>
            <p class="mt-4 text-xl font-semibold text-sky-700">{{ $service->price_formatted }}</p>

            @if($availabilities->isEmpty())
                <p class="mt-6 text-slate-400">Não há horários disponíveis no momento. Volte mais tarde.</p>
            @else
                <form method="POST" action="{{ route('client.appointments.store') }}" class="mt-6 space-y-4">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <div>
                        <label class="block text-sm font-medium mb-1">Data</label>
                        <select name="date" id="date" required class="w-full border rounded-md px-3 py-2">
                            <option value="">Selecione uma data</option>
                            @foreach($availabilities as $date => $slots)
                                <option value="{{ $date }}">{{ \Illuminate\Support\Carbon::parse($date)->format('d/m/Y') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Horário</label>
                        <select name="time" id="time" required class="w-full border rounded-md px-3 py-2">
                            <option value="">Selecione uma data primeiro</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-sky-600 text-white py-2 rounded-md hover:bg-sky-500">Confirmar agendamento</button>
                    <a href="{{ route('client.services.index') }}" class="block text-center text-sm text-slate-600 hover:text-slate-900">Cancelar</a>
                </form>

                <script>
                    const slotsByDate = @json($availabilities->map(fn($slots) => $slots->map(fn($s) => \Illuminate\Support\Carbon::parse($s->time)->format('H:i'))));
                    const dateSelect = document.getElementById('date');
                    const timeSelect = document.getElementById('time');

                    dateSelect.addEventListener('change', function () {
                        const times = slotsByDate[this.value] || [];
                        timeSelect.innerHTML = '<option value="">Selecione um horário</option>' +
                            times.map(t => `<option value="${t}">${t}</option>`).join('');
                    });
                </script>
            @endif
        </div>
    </div>
@endsection
