<div>
    <label class="block text-sm font-medium mb-1">Nome</label>
    <input type="text" name="name" value="{{ old('name', $service->name ?? '') }}" required class="w-full border rounded-md px-3 py-2">
</div>
<div>
    <label class="block text-sm font-medium mb-1">Descrição</label>
    <textarea name="description" required rows="3" class="w-full border rounded-md px-3 py-2">{{ old('description', $service->description ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium mb-1">Preço (R$)</label>
    <input type="text" name="price" value="{{ old('price', isset($service) ? number_format($service->price_cents / 100, 2, ',', '') : '') }}" placeholder="80,00" required class="w-full border rounded-md px-3 py-2">
</div>
<label class="flex items-center gap-2 text-sm">
    <input type="checkbox" name="active" value="1" {{ old('active', $service->active ?? true) ? 'checked' : '' }}> Ativo
</label>
