@extends('layouts.app')

@section('title', $service->name . ' - TechFix')

@section('content')
    <div class="max-w-xl bg-white border rounded-lg p-6 shadow-sm">
        <h1 class="text-2xl font-bold">{{ $service->name }}</h1>
        <p class="mt-3 text-slate-600">{{ $service->description }}</p>
        <p class="mt-4 text-xl font-semibold text-sky-700">{{ $service->price_formatted }}</p>

        <a href="{{ route('client.appointments.create', $service) }}" class="inline-block mt-6 bg-sky-600 text-white px-5 py-2.5 rounded-md hover:bg-sky-500">Agendar este serviço</a>
    </div>
@endsection
