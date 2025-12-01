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

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="px-6 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">
                        🎯 Panel de Control
                    </h1>
                    <p class="text-gray-600 mt-2">
                        Bienvenido, <span class="font-semibold text-gray-900">{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ now()->format('l, j \\d\\e F \\d\\e Y') }}</p>
                </div>
            </div>
        </div>

        <!-- KPI Cards - Estadísticas Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Tarjeta: Productos -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-t-4 border-blue-500">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">📦 Productos</p>
                        <p class="text-4xl font-bold text-gray-900 mt-3">{{ $totalProductos }}</p>
                        <p class="text-xs text-gray-400 mt-2">En catálogo</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-full p-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Pedidos -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-t-4 border-green-500">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">📋 Pedidos</p>
                        <p class="text-4xl font-bold text-gray-900 mt-3">{{ $totalPedidos }}</p>
                        <p class="text-xs text-gray-400 mt-2">Total registrados</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-full p-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Clientes -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-t-4 border-purple-500">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">👥 Clientes</p>
                        <p class="text-4xl font-bold text-gray-900 mt-3">{{ $totalClientes }}</p>
                        <p class="text-xs text-gray-400 mt-2">Registrados</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-full p-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 10a9 9 0 01-9 9m9-9a9 9 0 019 9m-9-9a9 9 0 00-9 9"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Ventas Hoy -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-t-4 border-orange-500">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">💰 Ventas Hoy</p>
                        <p class="text-4xl font-bold text-gray-900 mt-3">${{ number_format($ventasHoy, 2) }}</p>
                        <p class="text-xs text-gray-400 mt-2">Hoy</p>
                    </div>
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-full p-4">
                        <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.16 5.314l4.897-1.596A1 1 0 0115 4.001v12.998a1 1 0 01-1.938.122l-4.897-1.596a1 1 0 00-.164-.041H3a1 1 0 01-1-1V6a1 1 0 011-1h5.16z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen de Ventas -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Ventas Totales -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">📊 Resumen de Ventas</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div class="border-b-2 border-green-200 pb-4">
                        <p class="text-gray-600 text-sm font-medium">Ventas Totales</p>
                        <p class="text-4xl font-bold text-green-600 mt-3">${{ number_format($ventasTotal, 2) }}</p>
                        <p class="text-xs text-gray-400 mt-2">Completadas</p>
                    </div>
                    <div class="border-b-2 border-blue-200 pb-4">
                        <p class="text-gray-600 text-sm font-medium">Promedio por Pedido</p>
                        <p class="text-4xl font-bold text-blue-600 mt-3">
                            ${{ $totalPedidos > 0 ? number_format($ventasTotal / $totalPedidos, 2) : '0.00' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-2">Valor promedio</p>
                    </div>
                </div>
            </div>

            <!-- Estado de Plataforma -->
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl shadow-lg p-8 border-l-4 border-indigo-500">
                <h3 class="text-lg font-bold text-indigo-900 mb-4">✅ Estado del Sistema</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                        <span class="text-sm text-indigo-800">Base de datos: Operativo</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                        <span class="text-sm text-indigo-800">Servidor: Operativo</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                        <span class="text-sm text-indigo-800">API: Disponible</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">🚀 Accesos Rápidos</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Productos -->
                <a href="{{ route('admin.productos') }}" class="group bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border-2 border-blue-300 rounded-2xl p-6 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center mb-3">
                        <div class="bg-blue-500 text-white rounded-lg p-3 group-hover:bg-blue-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="font-bold text-blue-900 text-lg">Gestionar Productos</p>
                    <p class="text-sm text-blue-700 mt-2">Agregar, editar o eliminar productos del catálogo</p>
                    <div class="mt-4 flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition-transform">
                        Ver más <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </a>

                <!-- Pedidos -->
                <a href="{{ route('admin.pedidos') }}" class="group bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 border-2 border-green-300 rounded-2xl p-6 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center mb-3">
                        <div class="bg-green-500 text-white rounded-lg p-3 group-hover:bg-green-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="font-bold text-green-900 text-lg">Gestionar Pedidos</p>
                    <p class="text-sm text-green-700 mt-2">Ver, actualizar estado y gestionar pedidos de clientes</p>
                    <div class="mt-4 flex items-center text-green-600 font-semibold group-hover:translate-x-2 transition-transform">
                        Ver más <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </a>

                <!-- Reportes -->
                <a href="{{ route('admin.reportes') }}" class="group bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 border-2 border-purple-300 rounded-2xl p-6 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center mb-3">
                        <div class="bg-purple-500 text-white rounded-lg p-3 group-hover:bg-purple-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="font-bold text-purple-900 text-lg">Reportes y Análisis</p>
                    <p class="text-sm text-purple-700 mt-2">Análisis detallado de ventas, tendencias y desempeño</p>
                    <div class="mt-4 flex items-center text-purple-600 font-semibold group-hover:translate-x-2 transition-transform">
                        Ver más <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
