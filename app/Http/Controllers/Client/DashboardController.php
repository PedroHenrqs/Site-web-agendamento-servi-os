<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $appointments = $user->appointments()->with("service")
            ->orderByDesc("date")->orderByDesc("time")->get();

        $proximoAgendamento = $user->appointments()
            ->with("service")
            ->whereIn("status", ["pendente", "agendado"])
            ->whereDate("date", ">=", now()->toDateString())
            ->orderBy("date")
            ->orderBy("time")
            ->first();

        return view("client.dashboard", [
            "totalAgendamentos" => $appointments->count(),
            "proximoAgendamento" => $proximoAgendamento,
            "ultimosAgendamentos" => $appointments->take(5),
        ]);
    }
}
