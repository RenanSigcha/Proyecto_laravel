<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component
{
    //
}; ?>

<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Reportes y Análisis</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Ventas por Categoría -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ventas por Categoría</h2>
                        <ul class="space-y-2">
                            <li class="flex justify-between">
                                <span class="text-gray-600">Semillas</span>
                                <span class="font-semibold">$1,250.00</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600">Fertilizantes</span>
                                <span class="font-semibold">$850.00</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600">Pesticidas</span>
                                <span class="font-semibold">$620.00</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Productos Más Vendidos -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Productos Top 5</h2>
                        <ul class="space-y-2">
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-600">Semilla Tomate</span>
                                <span class="font-semibold">45 vendidas</span>
                            </li>
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-600">Fertilizante NPK</span>
                                <span class="font-semibold">32 vendidas</span>
                            </li>
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-600">Pesticida Orgánico</span>
                                <span class="font-semibold">28 vendidas</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Información General -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Este Mes</h2>
                        <ul class="space-y-2">
                            <li class="flex justify-between">
                                <span class="text-gray-600">Pedidos</span>
                                <span class="font-semibold">127</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600">Ingresos</span>
                                <span class="font-semibold">$8,450.00</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600">Ticket Promedio</span>
                                <span class="font-semibold">$66.54</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
