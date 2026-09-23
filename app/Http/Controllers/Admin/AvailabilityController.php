<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availabilities = Availability::orderBy("date")->orderBy("time")->get()
            ->groupBy(fn ($item) => $item->date->format("Y-m-d"));

        return view("admin.availabilities.index", compact("availabilities"));
    }

    public function create()
    {
        return view("admin.availabilities.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "date" => ["required", "date_format:Y-m-d", "after_or_equal:today"],
            "time" => ["required", "date_format:H:i"],
        ]);

        Availability::firstOrCreate(
            ["date" => $request->date, "time" => $request->time],
            ["available" => true]
        );

        return back()->with("status", "Horário cadastrado com sucesso.");
    }

    public function destroy(Availability $availability)
    {
        if (! $availability->available) {
            return back()->with("status", "Este horário já está em uso em um agendamento e não pode ser removido.");
        }

        $availability->delete();

        return back()->with("status", "Horário removido.");
    }
}
