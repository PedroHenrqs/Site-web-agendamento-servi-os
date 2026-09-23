@extends('layouts.app')

@section('title', 'Novo Horário - Admin')

@section('content')
    <div class="max-w-sm bg-white border rounded-lg p-6 shadow-sm">
        <h1 class="text-xl font-bold mb-4">Novo horário disponível</h1>
        <form method="POST" action="{{ route('admin.availabilities.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Data</label>
                <input type="date" name="date" required class="w-full border rounded-md px-3 py-2" min="{{ now()->toDateString() }}">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Horário</label>
                <input type="time" name="time" required class="w-full border rounded-md px-3 py-2">
            </div>
            <button type="submit" class="w-full bg-sky-600 text-white py-2 rounded-md hover:bg-sky-500">Cadastrar</button>
        </form>
    </div>
@endsection
