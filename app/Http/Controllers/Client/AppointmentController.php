<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Availability;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Auth::user()->appointments()->with('service')
            ->orderByDesc('date')->orderByDesc('time')->get();

        return view('client.appointments.index', compact('appointments'));
    }

    public function create(Service $service)
    {
        abort_unless($service->active, 404, 'Este serviço não está disponível.');

        $availabilities = Availability::where('available', true)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')->orderBy('time')->get()
            ->groupBy(fn ($item) => $item->date->format('Y-m-d'));

        return view('client.appointments.create', compact('service', 'availabilities'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $service = Service::findOrFail($request->service_id);
        abort_unless($service->active, 422, 'Este serviço não está mais disponível.');

        DB::transaction(function () use ($request, $service) {
            $slot = Availability::whereDate('date', $request->date)
                ->where('time', $request->time)
                ->where('available', true)
                ->lockForUpdate()
                ->first();

            if (! $slot) {
                abort(422, 'O horário selecionado não está mais disponível.');
            }

            $jaExiste = Appointment::where('date', $request->date)
                ->where('time', $request->time)
                ->exists();

            if ($jaExiste) {
                abort(422, 'Este horário já foi reservado por outro cliente.');
            }

            $slot->update(['available' => false]);

            Appointment::create([
                'user_id' => Auth::id(),
                'service_id' => $service->id,
                'date' => $request->date,
                'time' => $request->time,
                'status' => 'pendente',
            ]);
        });

        return redirect()->route('client.appointments.index')
            ->with('status', 'Agendamento realizado com sucesso! Aguarde a confirmação.');
    }

    public function cancel(Appointment $appointment)
    {
        abort_unless($appointment->user_id === Auth::id(), 403);
        abort_unless(in_array($appointment->status, [
            Appointment::STATUS_PENDENTE,
            Appointment::STATUS_AGENDADO,
        ], true), 422, 'Este agendamento não pode mais ser cancelado.');

        DB::transaction(function () use ($appointment) {
            Availability::whereDate('date', $appointment->date)
                ->where('time', $appointment->time)
                ->update(['available' => true]);

            $appointment->update(['status' => Appointment::STATUS_CANCELADO]);
        });

        return redirect()->route('client.appointments.index')
            ->with('status', 'Agendamento cancelado com sucesso.');
    }
}
