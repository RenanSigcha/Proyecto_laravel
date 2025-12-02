<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-6xl px-6 lg:max-w-7xl">
                    <!-- Cabecera / Navbar -->
                    <header class="flex items-center justify-between py-6">
                        <div class="flex items-center gap-4">
                            <a href="/" class="flex items-center gap-3">
                            <span class="text-lg font-semibold">AgroRen</span>
                            </a>
                            <nav class="hidden md:flex items-center gap-4 ml-8">
                                <a href="/" class="text-sm font-medium hover:text-black/80">Inicio</a>
                                <div class="relative group">
                                    <button class="text-sm font-medium hover:text-black/80 inline-flex items-center gap-2">Tienda en línea
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div id="categories-dropdown" class="absolute left-0 mt-2 w-48 rounded bg-white shadow-md p-2 hidden group-hover:block dark:bg-zinc-900">
                                        <div class="text-xs text-gray-500 px-2">Cargando categorías...</div>
                                    </div>
                                </div>
                            </nav>
                        </div>

                        <div class="flex items-center gap-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('login')): ?>
                                    <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium">Iniciar sesión</a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('register')): ?>
                                    <a href="<?php echo e(route('register')); ?>" class="text-sm font-medium">Registrar</a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo e(url('/dashboard')); ?>" class="text-sm font-medium">Mi cuenta</a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </header>

                    <main class="mt-6 w-full">
                        <!-- Hero / Intro -->
                        <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-zinc-900 mb-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <h1 class="text-2xl font-bold">Bienvenido a la Tienda de Insumos Agrícolas</h1>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">Encuentra semillas, fertilizantes y herramientas para tu campo.</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <a href="/" class="inline-block rounded bg-[#FF2D20] px-4 py-2 text-white text-sm">Explorar tienda</a>
                                    <a href="/contacto" class="text-sm text-gray-600 dark:text-gray-300">Contacto</a>
                                </div>
                            </div>
                        </section>

                        <!-- Sección: Categorías + Productos Populares -->
                        <section class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                            <!-- Sidebar: Categorías -->
                            <aside class="lg:col-span-1 rounded bg-white p-4 shadow-sm dark:bg-zinc-900">
                                <h3 class="font-semibold mb-3">Categorías</h3>
                                <ul id="categories-list" class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                    <li class="text-xs text-gray-400">Cargando...</li>
                                </ul>
                            </aside>

                            <!-- Productos populares -->
                            <div class="lg:col-span-3">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold">Productos Populares</h2>
                                    <a href="/tienda" class="text-sm text-gray-600 dark:text-gray-300">Ver todos</a>
                                </div>

                                <div id="popular-products" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <!-- Productos serán cargados por JS -->
                                    <div class="col-span-full text-sm text-gray-500">Cargando productos...</div>
                                </div>
                            </div>
                        </section>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        Laravel v<?php echo e(Illuminate\Foundation\Application::VERSION); ?> (PHP v<?php echo e(PHP_VERSION); ?>)
                    </footer>
                </div>
            </div>
        </div>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productsContainer = document.getElementById('popular-products');
            const categoriesList = document.getElementById('categories-list');
            const categoriesDropdown = document.getElementById('categories-dropdown');

            function placeholderCard() {
                return `<div class="rounded-lg border p-4 bg-white dark:bg-zinc-800">
                    <div class="h-40 bg-gray-100 dark:bg-zinc-700 rounded mb-3"></div>
                    <div class="h-4 bg-gray-200 dark:bg-zinc-600 rounded w-3/4 mb-2"></div>
                    <div class="h-4 bg-gray-200 dark:bg-zinc-600 rounded w-1/3"></div>
                </div>`;
            }

            async function loadProducts() {
                try {
                    const resp = await fetch('/api/productos');
                    if (!resp.ok) throw new Error('Error cargando productos');
                    const json = await resp.json();
                    const products = json.data || [];

                    // Categorías únicas
                    const categories = Array.from(new Set(products.map(p => (p.categoria || p.category || 'Otros')))).filter(Boolean);
                    renderCategories(categories);
                    renderDropdown(categories);

                    // Elegir populares: si tienen 'popular_score' usarlo, sino ordenar por cantidad_disponible, sino aleatorio
                    const popular = products.slice().sort((a, b) => {
                        const pa = a.popular_score ?? a.cantidad_disponible ?? Math.random();
                        const pb = b.popular_score ?? b.cantidad_disponible ?? Math.random();
                        return pb - pa;
                    }).slice(0, 6);

                    renderProducts(popular);
                } catch (err) {
                    productsContainer.innerHTML = '<div class="text-red-500">No se pudieron cargar los productos.</div>';
                    console.error(err);
                }
            }

            function renderCategories(categories) {
                if (!categoriesList) return;
                if (!categories.length) {
                    categoriesList.innerHTML = '<li class="text-sm text-gray-500">No hay categorías</li>';
                    return;
                }
                categoriesList.innerHTML = categories.map(cat => `
                    <li>
                        <a href="#" data-cat="${cat}" class="block px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-zinc-800">${cat}</a>
                    </li>
                `).join('');

                // add click handlers
                categoriesList.querySelectorAll('a[data-cat]').forEach(a => {
                    a.addEventListener('click', function (e) {
                        e.preventDefault();
                        const cat = this.dataset.cat;
                        filterByCategory(cat);
                    });
                });
            }

            function renderDropdown(categories) {
                if (!categoriesDropdown) return;
                if (!categories.length) {
                    categoriesDropdown.innerHTML = '<div class="text-xs text-gray-500 px-2">Sin categorías</div>';
                    return;
                }
                categoriesDropdown.innerHTML = categories.map(cat => `
                    <a href="/tienda?categoria=${encodeURIComponent(cat)}" class="block px-2 py-1 text-sm hover:bg-gray-100 dark:hover:bg-zinc-800">${cat}</a>
                `).join('');
            }

            function renderProducts(products) {
                if (!productsContainer) return;
                if (!products.length) {
                    productsContainer.innerHTML = '<div class="text-sm text-gray-500">No hay productos disponibles.</div>';
                    return;
                }
                productsContainer.innerHTML = products.map(p => {
                    const img = p.imagen_url || (p.imagenes && p.imagenes[0] && p.imagenes[0].url) || 'https://via.placeholder.com/400x300?text=Producto';
                    const precio = (p.precio !== undefined) ? ('S/ ' + Number(p.precio).toFixed(2)) : '';
                    return `
                        <article class="rounded-lg border overflow-hidden bg-white dark:bg-zinc-800">
                            <a href="/tienda/${p.id}" class="block">
                                <div class="h-40 bg-gray-100 dark:bg-zinc-700 overflow-hidden flex items-center justify-center">
                                    <img src="${img}" alt="${escapeHtml(p.nombre || 'Producto')}" class="object-cover w-full h-full" />
                                </div>
                                <div class="p-3">
                                    <h3 class="text-sm font-medium mb-1">${escapeHtml(p.nombre || 'Producto')}</h3>
                                    <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">${escapeHtml(p.categoria || '')}</div>
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm font-semibold">${precio}</div>
                                        <div class="text-xs text-gray-500">Stock: ${p.cantidad_disponible ?? '-'}</div>
                                    </div>
                                </div>
                            </a>
                        </article>
                    `;
                }).join('');
            }

            function filterByCategory(cat) {
                // simple refetch and filter
                fetch('/api/productos')
                    .then(r => r.json())
                    .then(j => {
                        const products = j.data || [];
                        const filtered = products.filter(p => (p.categoria || p.category || 'Otros') === cat);
                        renderProducts(filtered.slice(0, 12));
                    }).catch(err => console.error(err));
            }

            function escapeHtml(text) {
                if (!text) return '';
                return text.replace(/[&<>\"']/g, function (m) { return ({'&':'&amp;','<':'&lt;','>':'&gt;','\"':'&quot;',"'":"&#39;"})[m]; });
            }

            // Carga inicial
            loadProducts();
        });
    </script>
</html>
<?php /**PATH C:\xampp\htdocs\Renan\resources\views/welcome.blade.php ENDPATH**/ ?>