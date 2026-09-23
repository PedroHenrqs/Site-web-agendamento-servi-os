@extends('layouts.app')

@section('title', 'Agendamento - Admin')

@section('content')
    <div class="max-w-lg mx-auto bg-white border rounded-lg p-6 shadow-sm">
        <h1 class="text-xl font-bold mb-4">Detalhes do agendamento</h1>

        <dl class="space-y-2 text-sm">
            <div><dt class="text-slate-500 inline">Cliente:</dt> <dd class="inline font-medium">{{ $appointment->user->name }} ({{ $appointment->user->email }})</dd></div>
            <div><dt class="text-slate-500 inline">Serviço:</dt> <dd class="inline font-medium">{{ $appointment->service->name }}</dd></div>
            <div><dt class="text-slate-500 inline">Valor:</dt> <dd class="inline font-medium">{{ $appointment->service->price_formatted }}</dd></div>
            <div><dt class="text-slate-500 inline">Data:</dt> <dd class="inline font-medium">{{ $appointment->date->format('d/m/Y') }}</dd></div>
            <div><dt class="text-slate-500 inline">Horário:</dt> <dd class="inline font-medium">{{ \Illuminate\Support\Carbon::parse($appointment->time)->format('H:i') }}</dd></div>
            <div><dt class="text-slate-500 inline">Status atual:</dt> <dd class="inline font-medium">{{ $appointment->statusLabel() }}</dd></div>
        </dl>

        <form method="POST" action="{{ route('admin.appointments.status', $appointment) }}" class="mt-6 flex items-center gap-3">
            @csrf
            @method('PATCH')
            <select name="status" class="border rounded-md px-3 py-2 text-sm">
                @foreach(\App\Models\Appointment::STATUSES as $status)
                    <option value="{{ $status }}" {{ $appointment->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-500 text-sm">Atualizar status</button>
        </form>

        <a href="{{ route('admin.appointments.index') }}" class="inline-block mt-6 text-sm text-slate-500 underline">Voltar</a>
    </div>
@endsection
