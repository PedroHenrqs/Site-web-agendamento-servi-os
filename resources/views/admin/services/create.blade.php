@extends('layouts.app')

@section('title', 'Novo Serviço - Admin')

@section('content')
    <div class="max-w-lg mx-auto bg-white border rounded-lg p-6 shadow-sm">
        <h1 class="text-xl font-bold mb-4">Novo serviço</h1>
        <form method="POST" action="{{ route('admin.services.store') }}" class="space-y-4">
            @csrf
            @include('admin.services._form')
            <button type="submit" class="w-full bg-sky-600 text-white py-2 rounded-md hover:bg-sky-500">Salvar</button>
        </form>
    </div>
@endsection
