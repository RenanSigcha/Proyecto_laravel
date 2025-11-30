<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Pedido;

new #[Layout('layouts.admin')] class extends Component
{
    public function mount(): void
    {
        // Cargar pedidos
    }
}; ?>

<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Gestión de Pedidos</h1>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold">ID Pedido</th>
                                <th class="px-6 py-3 font-semibold">Cliente</th>
                                <th class="px-6 py-3 font-semibold">Total</th>
                                <th class="px-6 py-3 font-semibold">Estado</th>
                                <th class="px-6 py-3 font-semibold">Pago</th>
                                <th class="px-6 py-3 font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-6 py-4">#12345</td>
                                <td class="px-6 py-4">Renan Sigcha</td>
                                <td class="px-6 py-4">$250.00</td>
                                <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">En Espera</span></td>
                                <td class="px-6 py-4"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Completado</span></td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800">Ver Detalles</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
