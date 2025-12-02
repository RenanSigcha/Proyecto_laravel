<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Pedido;

new #[Layout('layouts.admin')] class extends Component
{
    public array $pedidos = [];

    public function mount(): void
    {
        $this->pedidos = Pedido::with('user')
            ->latest()
            ->limit(50)
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'user_id' => $p->user_id,
                'cliente' => $p->user?->nombre . ' ' . $p->user?->apellido,
                'total_a_pagar' => $p->total_a_pagar,
                'estado' => $p->estado,
                'payment_status' => $p->payment_status,
            ])
            ->toArray();
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
                            <?php if (!empty($pedidos) && count($pedidos) > 0): ?>
                                <?php foreach ($pedidos as $p): ?>
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-6 py-4">#<?= e($p['id']) ?></td>
                                        <td class="px-6 py-4"><?= e($p['cliente'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4">S/ <?= number_format($p['total_a_pagar'] ?? 0, 2) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm"><?= e($p['estado'] ?? 'pendiente') ?></span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="<?= ($p['payment_status'] === 'completed') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?> px-3 py-1 rounded-full text-sm">
                                                <?= e($p['payment_status'] ?? 'pendiente') ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="text-blue-600 hover:text-blue-800">Ver Detalles</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay pedidos registrados</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
