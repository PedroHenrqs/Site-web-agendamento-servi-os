<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\AvailabilityController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Client\AppointmentController as ClientAppointmentController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ServiceController as ClientServiceController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::get("/", [HomeController::class, "index"])->name("home");

// Autenticação
Route::middleware("guest")->group(function () {
    Route::get("/registrar", [RegisteredUserController::class, "create"])->name("register");
    Route::post("/registrar", [RegisteredUserController::class, "store"]);
    Route::get("/login", [AuthenticatedSessionController::class, "create"])->name("login");
    Route::post("/login", [AuthenticatedSessionController::class, "store"]);
});

Route::middleware("auth")->post("/logout", [AuthenticatedSessionController::class, "destroy"])->name("logout");

// Área do cliente
Route::middleware("auth")->prefix("cliente")->name("client.")->group(function () {
    Route::get("/dashboard", [ClientDashboardController::class, "index"])->name("dashboard");

    Route::get("/servicos", [ClientServiceController::class, "index"])->name("services.index");
    Route::get("/servicos/{service}", [ClientServiceController::class, "show"])->name("services.show");

    Route::get("/servicos/{service}/agendar", [ClientAppointmentController::class, "create"])->name("appointments.create");
    Route::post("/agendamentos", [ClientAppointmentController::class, "store"])->name("appointments.store");
    Route::get("/agendamentos", [ClientAppointmentController::class, "index"])->name("appointments.index");
});

// Área administrativa
Route::middleware(["auth", "admin"])->prefix("admin")->name("admin.")->group(function () {
    Route::get("/dashboard", [AdminDashboardController::class, "index"])->name("dashboard");

    Route::resource("servicos", AdminServiceController::class)
        ->parameters(["servicos" => "service"])
        ->names("services")
        ->except(["show"]);

    Route::get("/agendamentos", [AdminAppointmentController::class, "index"])->name("appointments.index");
    Route::get("/agendamentos/{appointment}", [AdminAppointmentController::class, "show"])->name("appointments.show");
    Route::patch("/agendamentos/{appointment}/status", [AdminAppointmentController::class, "updateStatus"])->name("appointments.status");

    Route::get("/disponibilidade", [AvailabilityController::class, "index"])->name("availabilities.index");
    Route::get("/disponibilidade/nova", [AvailabilityController::class, "create"])->name("availabilities.create");
    Route::post("/disponibilidade", [AvailabilityController::class, "store"])->name("availabilities.store");
    Route::delete("/disponibilidade/{availability}", [AvailabilityController::class, "destroy"])->name("availabilities.destroy");
});
