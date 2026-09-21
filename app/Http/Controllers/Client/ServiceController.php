<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where("active", true)->orderBy("name")->get();

        return view("client.services.index", compact("services"));
    }

    public function show(Service $service)
    {
        abort_unless($service->active, 404);

        return view("client.services.show", compact("service"));
    }
}
