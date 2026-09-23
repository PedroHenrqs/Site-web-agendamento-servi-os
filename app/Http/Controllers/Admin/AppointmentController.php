<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(["user", "service"])
            ->orderByDesc("date")->orderByDesc("time")->get();

        return view("admin.appointments.index", compact("appointments"));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(["user", "service"]);

        return view("admin.appointments.show", compact("appointment"));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            "status" => ["required", "in:" . implode(",", Appointment::STATUSES)],
        ]);

        $appointment->update(["status" => $request->status]);

        return back()->with("status", "Status do agendamento atualizado.");
    }
}
