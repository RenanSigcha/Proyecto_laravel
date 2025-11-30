<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Producto;

new #[Layout('layouts.admin')] class extends Component
{
    public function mount(): void
    {
        // Cargar productos
    }
}; ?>

<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Productos</h1>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                        + Agregar Producto
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Nombre</th>
                                <th class="px-6 py-3 font-semibold">SKU</th>
                                <th class="px-6 py-3 font-semibold">Precio</th>
                                <th class="px-6 py-3 font-semibold">Stock</th>
                                <th class="px-6 py-3 font-semibold">Categoría</th>
                                <th class="px-6 py-3 font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-6 py-4">Semilla de Tomate</td>
                                <td class="px-6 py-4">SKU-001</td>
                                <td class="px-6 py-4">$25.50</td>
                                <td class="px-6 py-4">150</td>
                                <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Semillas</span></td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800 mr-4">Editar</button>
                                    <button class="text-red-600 hover:text-red-800">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
