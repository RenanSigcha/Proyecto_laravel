<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?> - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin.css', 'resources/js/admin.js']); ?>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <?php use App\Models\Producto; $__productos_count = Producto::count(); ?>
        <div class="flex h-screen">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-900 text-white flex flex-col">
                <!-- Logo -->
                <div class="px-6 py-8">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        <span class="ml-3 text-xl font-bold">Admin Panel</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-8 space-y-2">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-2 rounded-lg <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-800'); ?> transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>

                    <a href="<?php echo e(route('admin.productos')); ?>" class="flex items-center justify-between px-4 py-2 rounded-lg <?php echo e(request()->routeIs('admin.productos*') ? 'bg-gray-700' : 'hover:bg-gray-800'); ?> transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
                        </svg>
                        <span class="ml-3">Productos</span>
                        <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-600 text-white"><?php echo e($__productos_count); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.pedidos')); ?>" class="flex items-center px-4 py-2 rounded-lg <?php echo e(request()->routeIs('admin.pedidos*') ? 'bg-gray-700' : 'hover:bg-gray-800'); ?> transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3">Pedidos</span>
                    </a>

                    <a href="<?php echo e(route('admin.reportes')); ?>" class="flex items-center px-4 py-2 rounded-lg <?php echo e(request()->routeIs('admin.reportes*') ? 'bg-gray-700' : 'hover:bg-gray-800'); ?> transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                        <span class="ml-3">Reportes</span>
                    </a>
                </nav>

                <!-- User Section -->
                <div class="px-4 py-6 border-t border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold"><?php echo e(auth()->user()->nombre); ?></p>
                            <p class="text-xs text-gray-400">Administrador</p>
                        </div>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-gray-400 hover:text-white">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto">
                <?php echo $slot; ?>

            </main>
        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\Renan\resources\views/layouts/admin.blade.php ENDPATH**/ ?>