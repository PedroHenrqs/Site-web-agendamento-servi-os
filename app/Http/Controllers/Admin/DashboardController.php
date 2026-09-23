<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view("admin.dashboard", [
            "totalClientes" => User::where("role", "cliente")->count(),
            "totalServicos" => Service::count(),
            "totalAgendamentos" => Appointment::count(),
            "agendamentosPendentes" => Appointment::where("status", "pendente")->count(),
            "agendamentosConcluidos" => Appointment::where("status", "concluido")->count(),
            "proximosAtendimentos" => Appointment::with(["user", "service"])
                ->whereIn("status", ["pendente", "agendado"])
                ->whereDate("date", ">=", now()->toDateString())
                ->orderBy("date")->orderBy("time")
                ->take(5)->get(),
        ]);
    }
}
