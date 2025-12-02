<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Producto;

new #[Layout('layouts.admin')] class extends Component
{
    public array $productos = [];

    public function mount(): void
    {
        // Cargar productos inicialmente para renderizado del servidor
        $this->productos = Producto::orderBy('id', 'desc')->get()->toArray();
    }
}; ?>

<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Productos</h1>
                    <button id="open-create-product" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
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
                        <tbody id="productos-tbody">
                            <?php if (!empty($productos) && count($productos) > 0): ?>
                                <?php foreach ($productos as $p): ?>
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-6 py-4"><?= e($p['nombre'] ?? '') ?></td>
                                        <td class="px-6 py-4"><?= e($p['sku'] ?? '') ?></td>
                                        <td class="px-6 py-4">$<?= number_format($p['precio'] ?? 0, 2) ?></td>
                                        <td class="px-6 py-4"><?= e($p['cantidad_disponible'] ?? 0) ?></td>
                                        <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm"><?= e($p['categoria'] ?? '') ?></span></td>
                                        <td class="px-6 py-4">
                                            <button data-id="<?= e($p['id']) ?>" class="edit-btn text-blue-600 hover:text-blue-800 mr-4">Editar</button>
                                            <button data-id="<?= e($p['id']) ?>" class="delete-btn text-red-600 hover:text-red-800">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="px-6 py-4">No hay productos</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mensajes / Carga -->
                <div id="productos-status" class="mt-4 text-sm text-gray-600"></div>

                <!-- Modal Crear/Editar -->
                <div id="producto-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
                    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-2xl p-6">
                        <h3 id="modal-title" class="text-xl font-bold mb-4">Crear Producto</h3>
                        <form id="producto-form">
                            <input type="hidden" id="producto-id">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Nombre</label>
                                    <input id="nombre" class="mt-1 block w-full border rounded px-3 py-2" required />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">SKU</label>
                                    <input id="sku" class="mt-1 block w-full border rounded px-3 py-2" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Precio</label>
                                    <input id="precio" type="number" step="0.01" class="mt-1 block w-full border rounded px-3 py-2" required />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Stock</label>
                                    <input id="cantidad_disponible" type="number" class="mt-1 block w-full border rounded px-3 py-2" required />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium">Categoría</label>
                                    <input id="categoria" class="mt-1 block w-full border rounded px-3 py-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium">Descripción</label>
                                    <textarea id="descripcion" class="mt-1 block w-full border rounded px-3 py-2"></textarea>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" id="modal-cancel" class="px-4 py-2 rounded bg-gray-200">Cancelar</button>
                                <button type="submit" id="modal-save" class="px-4 py-2 rounded bg-blue-600 text-white">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    (function(){
                        const tbody = document.getElementById('productos-tbody');
                        const modal = document.getElementById('producto-modal');
                        const form = document.getElementById('producto-form');
                        const modalTitle = document.getElementById('modal-title');
                        const cancelBtn = document.getElementById('modal-cancel');
                        const status = document.getElementById('productos-status');
                        const openCreateBtn = document.getElementById('open-create-product');

                        function setStatus(msg, isError = false){
                            status.textContent = msg || '';
                            status.className = isError ? 'mt-4 text-sm text-red-600' : 'mt-4 text-sm text-gray-600';
                        }

                        // Helpers
                        function showModal(mode, product = null) {
                            modalTitle.textContent = mode === 'edit' ? 'Editar Producto' : 'Crear Producto';
                            document.getElementById('producto-id').value = product?.id || '';
                            document.getElementById('nombre').value = product?.nombre || '';
                            document.getElementById('sku').value = product?.sku || '';
                            document.getElementById('precio').value = product?.precio || '';
                            document.getElementById('cantidad_disponible').value = product?.cantidad_disponible || '';
                            document.getElementById('categoria').value = product?.categoria || '';
                            document.getElementById('descripcion').value = product?.descripcion || '';
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        }

                        function hideModal(){
                            modal.classList.remove('flex');
                            modal.classList.add('hidden');
                        }

                        cancelBtn.addEventListener('click', function(){ hideModal(); });

                        // CSRF + initial load
                        function init(){
                            setStatus('Cargando productos...');
                            axios.get('/sanctum/csrf-cookie').then(() => {
                                loadProductos();
                            }).catch(err => {
                                console.error(err);
                                setStatus('No se pudo inicializar. Revise la consola.', true);
                            });
                        }

                        function loadProductos(){
                            axios.get('/api/productos')
                                .then(resp => {
                                    const items = resp.data.data || resp.data || [];
                                    renderProductos(items);
                                    setStatus('');
                                }).catch(err => {
                                    console.error(err);
                                    setStatus('Error cargando productos', true);
                                    tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-red-600">Error cargando productos</td></tr>';
                                });
                        }

                        function renderProductos(items){
                            if(!items || items.length === 0){
                                tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4">No hay productos</td></tr>';
                                return;
                            }

                            tbody.innerHTML = '';
                            items.forEach(p => {
                                const tr = document.createElement('tr');
                                tr.className = 'border-t hover:bg-gray-50';
                                tr.innerHTML = `
                                    <td class="px-6 py-4">${escapeHtml(p.nombre)}</td>
                                    <td class="px-6 py-4">${escapeHtml(p.sku || '')}</td>
                                    <td class="px-6 py-4">$${Number(p.precio).toFixed(2)}</td>
                                    <td class="px-6 py-4">${p.cantidad_disponible ?? 0}</td>
                                    <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">${escapeHtml(p.categoria || '')}</span></td>
                                    <td class="px-6 py-4">
                                        <button data-id="${p.id}" class="edit-btn text-blue-600 hover:text-blue-800 mr-4">Editar</button>
                                        <button data-id="${p.id}" class="delete-btn text-red-600 hover:text-red-800">Eliminar</button>
                                    </td>
                                `;
                                tbody.appendChild(tr);
                            });

                            // attach events
                            document.querySelectorAll('.edit-btn').forEach(b => b.addEventListener('click', e => {
                                const id = e.currentTarget.getAttribute('data-id');
                                const item = Array.from(items).find(x => String(x.id) === String(id));
                                showModal('edit', item);
                            }));

                            document.querySelectorAll('.delete-btn').forEach(b => b.addEventListener('click', e => {
                                const id = e.currentTarget.getAttribute('data-id');
                                if(!confirm('Eliminar producto?')) return;
                                setStatus('Eliminando...');
                                axios.delete(`/api/productos/${id}`)
                                    .then(() => { loadProductos(); })
                                    .catch(err => { console.error(err); setStatus('Error eliminando', true); });
                            }));
                        }

                        // Escape helper to avoid XSS in injected HTML
                        function escapeHtml(unsafe){
                            return String(unsafe || '').replace(/[&<"'`=\\/]/g, function(s) {
                                return ({
                                    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '/': '&#x2F;', '`': '&#x60;', '=': '&#x3D;'
                                })[s];
                            });
                        }

                        // Form submit (create or update)
                        form.addEventListener('submit', function(e){
                            e.preventDefault();
                            const id = document.getElementById('producto-id').value;
                            const payload = {
                                nombre: document.getElementById('nombre').value,
                                sku: document.getElementById('sku').value,
                                precio: document.getElementById('precio').value,
                                cantidad_disponible: document.getElementById('cantidad_disponible').value,
                                categoria: document.getElementById('categoria').value,
                                descripcion: document.getElementById('descripcion').value,
                            };

                            setStatus('Guardando...');

                            if(id){
                                axios.put(`/api/productos/${id}`, payload)
                                    .then(() => { hideModal(); loadProductos(); })
                                    .catch(err => { console.error(err); setStatus('Error actualizando', true); });
                            } else {
                                axios.post('/api/productos', payload)
                                    .then(() => { hideModal(); loadProductos(); })
                                    .catch(err => { console.error(err); setStatus('Error creando', true); });
                            }
                        });

                        // Bind create button
                        if(openCreateBtn){
                            openCreateBtn.addEventListener('click', function(){
                                showModal('create');
                            });
                        }

                        // init
                        init();
                    })();
                </script>
            </div>
        </div>
    </div>
</div>
