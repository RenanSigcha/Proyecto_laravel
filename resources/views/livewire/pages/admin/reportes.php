<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

new #[Layout('layouts.admin')] class extends Component
{
    public array $ventasPorCategoria = [];
    public array $topProductos = [];
    public int $totalPedidosMes = 0;
    public float $ingresosMes = 0.0;
    public float $ticketPromedio = 0.0;

    public function mount(): void
    {
        $this->cargarReportes();
    }

    private function cargarReportes(): void
    {
        // Ventas por categoría (últimos 30 días)
        $this->ventasPorCategoria = DB::table('detalles_pedidos')
            ->join('productos', 'detalles_pedidos.producto_id', '=', 'productos.id')
            ->join('pedidos', 'detalles_pedidos.pedido_id', '=', 'pedidos.id')
            ->where('pedidos.payment_status', 'completed')
            ->whereDate('pedidos.created_at', '>=', now()->subDays(30))
            ->groupBy('productos.categoria')
            ->selectRaw('productos.categoria, SUM(detalles_pedidos.subtotal) as total')
            ->get()
            ->map(fn($item) => ['categoria' => $item->categoria ?? 'Sin categoría', 'total' => number_format($item->total ?? 0, 2)])
            ->toArray();

        // Top 5 productos más vendidos
        $this->topProductos = DB::table('detalles_pedidos')
            ->join('productos', 'detalles_pedidos.producto_id', '=', 'productos.id')
            ->groupBy('productos.nombre')
            ->selectRaw('productos.nombre, SUM(detalles_pedidos.cantidad) as total_vendidas')
            ->orderByDesc('total_vendidas')
            ->limit(5)
            ->get()
            ->map(fn($item) => ['nombre' => $item->nombre, 'vendidas' => $item->total_vendidas])
            ->toArray();

        // Estadísticas de este mes
        $mesActual = Pedido::where('payment_status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
        
        $this->totalPedidosMes = $mesActual->count();
        $this->ingresosMes = $mesActual->sum('total_a_pagar');
        $this->ticketPromedio = $this->totalPedidosMes > 0 ? $this->ingresosMes / $this->totalPedidosMes : 0;
    }
}; ?>

<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Reportes y Análisis</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Ventas por Categoría -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ventas por Categoría (30d)</h2>
                        <?php if (!empty($ventasPorCategoria)): ?>
                            <ul class="space-y-2">
                                <?php foreach ($ventasPorCategoria as $cat): ?>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600"><?= e($cat['categoria']) ?></span>
                                        <span class="font-semibold">S/ <?= $cat['total'] ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-gray-500 text-sm">Sin datos disponibles</p>
                        <?php endif; ?>
                    </div>

                    <!-- Productos Más Vendidos -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Productos Top 5</h2>
                        <?php if (!empty($topProductos)): ?>
                            <ul class="space-y-2">
                                <?php foreach ($topProductos as $prod): ?>
                                    <li class="flex justify-between text-sm">
                                        <span class="text-gray-600"><?= e($prod['nombre']) ?></span>
                                        <span class="font-semibold"><?= $prod['vendidas'] ?> vendidas</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-gray-500 text-sm">Sin datos disponibles</p>
                        <?php endif; ?>
                    </div>

                    <!-- Información General -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Este Mes</h2>
                        <ul class="space-y-2">
                            <li class="flex justify-between">
                                <span class="text-gray-600">Pedidos</span>
                                <span class="font-semibold"><?= $totalPedidosMes ?></span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600">Ingresos</span>
                                <span class="font-semibold">S/ <?= number_format($ingresosMes, 2) ?></span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600">Ticket Promedio</span>
                                <span class="font-semibold">S/ <?= number_format($ticketPromedio, 2) ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
