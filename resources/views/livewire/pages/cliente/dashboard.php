<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Pedido;
use App\Models\CarritoCompra;

new #[Layout('layouts.app')] class extends Component
{
    public int $pedidosRecientesCount = 0;
    public int $itemsCarrito = 0;
    public array $pedidosRecientes = [];

    public function mount(): void
    {
        $this->pedidosRecientes = Pedido::where('user_id', auth()->id())->latest()->take(5)->get()->toArray();
        $this->pedidosRecientesCount = count($this->pedidosRecientes);
        $this->itemsCarrito = CarritoCompra::where('user_id', auth()->id())->count();
    }
}; ?>

<div class="min-h-screen p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Panel de Cliente</h1>
            <p class="mt-2 text-gray-600">Bienvenido, {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</p>
        </div>
        <div>
            <a href="{{ route('profile') }}" class="px-3 py-2 bg-gray-100 rounded">Mi Perfil</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">🧾 Pedidos recientes</p>
            <p class="text-2xl font-bold mt-2">{{ $pedidosRecientesCount }}</p>
            <p class="text-xs text-gray-400 mt-1">Últimos 5 pedidos</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">🛒 Items en carrito</p>
            <p class="text-2xl font-bold mt-2">{{ $itemsCarrito }}</p>
            <p class="text-xs text-gray-400 mt-1">Artículos en tu carrito</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">📦 Acciones</p>
            <div class="mt-3 space-y-2">
                <a href="/productos" class="block px-3 py-2 bg-indigo-600 text-white rounded">Ver productos</a>
                <a href="/carrito" class="block px-3 py-2 border rounded">Ir al carrito</a>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold">Pedidos recientes</h2>
        <?php if(!empty($pedidosRecientes)): ?>
            <div class="mt-4 space-y-3">
                <?php foreach($pedidosRecientes as $p): ?>
                    <div class="border rounded p-3 flex justify-between items-center">
                        <div>
                            <p class="font-semibold">Pedido #<?= $p['id'] ?></p>
                            <p class="text-sm text-gray-500">Estado: <?= $p['status'] ?? ($p['payment_status'] ?? 'N/A') ?></p>
                        </div>
                        <div class="text-sm text-gray-700">${{ number_format($p['total_a_pagar'] ?? 0, 2) }}</div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600 mt-4">No tienes pedidos recientes.</p>
        <?php endif; ?>
    </div>
</div>
