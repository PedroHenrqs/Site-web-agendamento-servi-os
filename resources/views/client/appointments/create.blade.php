@extends('layouts.app')

@section('title', 'Agendar - TechFix')

@section('content')
    <div class="max-w-xl bg-white border rounded-lg p-6 shadow-sm">
        <h1 class="text-xl font-bold mb-1">Agendar: {{ $service->name }}</h1>
        <p class="text-sky-700 font-medium mb-6">{{ $service->price_formatted }}</p>

        @if($availabilities->isEmpty())
            <p class="text-slate-400">Não há horários disponíveis no momento. Volte mais tarde.</p>
        @else
            <form method="POST" action="{{ route('client.appointments.store') }}" class="space-y-4">
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
@endsection
