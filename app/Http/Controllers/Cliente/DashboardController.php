<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Si no existe una vista livewire específica, usar layout simple
        if (view()->exists('livewire.pages.cliente.dashboard')) {
            return view('livewire.pages.cliente.dashboard');
        }

        return view('layouts.app', ['slot' => view('cliente.dashboard-basic')]);
    }
}
