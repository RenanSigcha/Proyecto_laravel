<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component
{
}; ?>

<div class="p-6">
    <h1 class="text-2xl font-bold">Usuarios</h1>
    <div class="mt-4">
        <div class="flex items-center justify-between mb-4">
            <form method="GET" action="" class="flex items-center gap-2">
                <input type="text" name="q" value="<?= request('q') ?>" placeholder="Buscar por nombre o correo" class="border rounded px-3 py-2" />
                <button class="px-3 py-2 bg-indigo-600 text-white rounded">Buscar</button>
            </form>
            <div>
                <p class="text-sm text-gray-600">Total: <strong><?= isset($users) ? $users->total() : 0 ?></strong></p>
            </div>
        </div>

        <?php if(isset($users) && $users->count()): ?>
            <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Nombre</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Correo</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Rol</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php foreach($users as $u): ?>
                        <tr>
                            <td class="px-4 py-3 text-sm"><?= $u->id ?></td>
                            <td class="px-4 py-3 text-sm"><?= $u->nombre ?> <?= $u->apellido ?></td>
                            <td class="px-4 py-3 text-sm"><?= $u->correo_electronico ?></td>
                            <td class="px-4 py-3 text-sm"> <span class="inline-block px-2 py-1 rounded <?= $u->role === 'admin' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?> "><?= $u->role ?></span></td>
                            <td class="px-4 py-3 text-sm">
                                <form method="POST" action="<?= route('admin.usuarios.role.update', $u->id) ?>" class="flex items-center gap-2">
                                    <?= csrf_field() ?>
                                    <select name="role" class="border rounded px-2 py-1">
                                        <option value="cliente" <?= $u->role === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                                        <option value="admin" <?= $u->role === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                    <button class="px-2 py-1 bg-indigo-600 text-white rounded text-sm">Actualizar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>

            <div class="mt-4">
                <?= $users->links() ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">No hay usuarios registrados.</p>
        <?php endif; ?>
    </div>
</div>
