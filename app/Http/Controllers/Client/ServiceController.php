<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('active', true)->orderBy('name')->get();

        return view('client.services.index', compact('services'));
    }
}
