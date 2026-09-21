<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy("name")->get();

        return view("admin.services.index", compact("services"));
    }

    public function create()
    {
        return view("admin.services.create");
    }

    public function store(StoreServiceRequest $request)
    {
        Service::create([
            "name" => $request->name,
            "description" => $request->description,
            "price_cents" => (int) round(((float) str_replace(",", ".", $request->price)) * 100),
            "active" => $request->boolean("active"),
        ]);

        return redirect()->route("admin.services.index")->with("status", "Serviço cadastrado com sucesso.");
    }

    public function edit(Service $service)
    {
        return view("admin.services.edit", compact("service"));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update([
            "name" => $request->name,
            "description" => $request->description,
            "price_cents" => (int) round(((float) str_replace(",", ".", $request->price)) * 100),
            "active" => $request->boolean("active"),
        ]);

        return redirect()->route("admin.services.index")->with("status", "Serviço atualizado com sucesso.");
    }

    public function destroy(Service $service)
    {
        if ($service->appointments()->exists()) {
            $service->update(["active" => false]);

            return back()->with("status", "Serviço possui agendamentos e foi apenas desativado.");
        }

        $service->delete();

        return back()->with("status", "Serviço excluído com sucesso.");
    }
}
