@extends('layouts.app')

@section('title', 'Editar Serviço - Admin')

@section('content')
    <div class="max-w-lg bg-white border rounded-lg p-6 shadow-sm">
        <h1 class="text-xl font-bold mb-4">Editar serviço</h1>
        <form method="POST" action="{{ route('admin.services.update', $service) }}" class="space-y-4">
            @csrf
            @method('PUT')
            @include('admin.services._form')
            <button type="submit" class="w-full bg-sky-600 text-white py-2 rounded-md hover:bg-sky-500">Atualizar</button>
        </form>
    </div>
@endsection
