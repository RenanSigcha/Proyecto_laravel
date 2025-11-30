<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\User;

new #[Layout('layouts.admin')] class extends Component
{
    public int $totalProductos = 0;
    public int $totalPedidos = 0;
    public int $totalClientes = 0;
    public float $ventasHoy = 0;
    public float $ventasTotal = 0;

    public function mount(): void
    {
        $this->loadStats();
    }

    private function loadStats(): void
    {
        $this->totalProductos = Producto::count();
        $this->totalPedidos = Pedido::count();
        $this->totalClientes = User::where('role', 'cliente')->count();
        
        // Ventas del día (pedidos completados hoy)
        $this->ventasHoy = Pedido::where('payment_status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total_a_pagar');
        
        // Ventas totales
        $this->ventasTotal = Pedido::where('payment_status', 'completed')
            ->sum('total_a_pagar');
    }
}; ?>

<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Panel Administrativo
                </h1>
                <p class="text-gray-600 mt-2">
                    Bienvenido, {{ auth()->user()->nombre }}. Aquí está el resumen de tu plataforma.
                </p>
            </div>

            <!-- Tarjetas de Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Productos -->
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold uppercase">Productos</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProductos }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Pedidos -->
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold uppercase">Pedidos</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalPedidos }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Clientes -->
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold uppercase">Clientes</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalClientes }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 10a9 9 0 01-9 9m9-9a9 9 0 019 9m-9-9a9 9 0 00-9 9"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Ventas Hoy -->
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold uppercase">Ventas Hoy</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($ventasHoy, 2) }}</p>
                        </div>
                        <div class="bg-orange-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.16 5.314l4.897-1.596A1 1 0 0115 4.001v12.998a1 1 0 01-1.938.122l-4.897-1.596a1 1 0 00-.164-.041H3a1 1 0 01-1-1V6a1 1 0 011-1h5.16z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ventas Totales -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Resumen General</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600 text-sm">Ventas Totales (Completadas)</p>
                        <p class="text-4xl font-bold text-green-600 mt-2">${{ number_format($ventasTotal, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Promedio por Pedido</p>
                        <p class="text-4xl font-bold text-blue-600 mt-2">
                            ${{ $totalPedidos > 0 ? number_format($ventasTotal / $totalPedidos, 2) : '0.00' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Accesos Rápidos</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.productos') }}" class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-4 transition">
                        <p class="font-semibold text-blue-900">Gestionar Productos</p>
                        <p class="text-sm text-blue-700 mt-1">Agregar, editar o eliminar productos</p>
                    </a>
                    <a href="{{ route('admin.pedidos') }}" class="bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-4 transition">
                        <p class="font-semibold text-green-900">Gestionar Pedidos</p>
                        <p class="text-sm text-green-700 mt-1">Ver y actualizar estado de pedidos</p>
                    </a>
                    <a href="{{ route('admin.reportes') }}" class="bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg p-4 transition">
                        <p class="font-semibold text-purple-900">Reportes</p>
                        <p class="text-sm text-purple-700 mt-1">Análisis de ventas y desempeño</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
