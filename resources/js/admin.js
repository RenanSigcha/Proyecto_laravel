// Admin JavaScript utilities

/**
 * Mostrar modal
 */
export function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

/**
 * Ocultar modal
 */
export function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

/**
 * Mostrar alerta
 */
export function showAlert(message, type = 'info', duration = 5000) {
    const alertContainer = document.getElementById('alert-container');
    if (!alertContainer) return;

    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    
    alertContainer.appendChild(alert);
    
    if (duration > 0) {
        setTimeout(() => {
            alert.remove();
        }, duration);
    }
    
    return alert;
}

/**
 * Confirmar acción
 */
export function confirmAction(message = '¿Estás seguro?') {
    return window.confirm(message);
}

/**
 * Escapar HTML para evitar XSS
 */
export function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return String(unsafe)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;')
        .replace(/\//g, '&#x2F;');
}

/**
 * Formatear moneda
 */
export function formatCurrency(value, currency = 'S/') {
    return `${currency} ${Number(value || 0).toFixed(2)}`;
}

/**
 * Formatear fecha
 */
export function formatDate(date) {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('es-PE', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
}

/**
 * Hacer petición GET con manejo de errores
 */
export async function apiGet(url) {
    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error(`Error en GET ${url}:`, error);
        throw error;
    }
}

/**
 * Hacer petición POST con manejo de errores
 */
export async function apiPost(url, data = {}) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error(`Error en POST ${url}:`, error);
        throw error;
    }
}

/**
 * Hacer petición PUT con manejo de errores
 */
export async function apiPut(url, data = {}) {
    try {
        const response = await fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error(`Error en PUT ${url}:`, error);
        throw error;
    }
}

/**
 * Hacer petición DELETE con manejo de errores
 */
export async function apiDelete(url) {
    try {
        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
            },
        });
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error(`Error en DELETE ${url}:`, error);
        throw error;
    }
}

/**
 * Obtener token CSRF del documento
 */
export function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

/**
 * Inicializar eventos comunes del admin
 */
export function initAdminEvents() {
    // Cerrar modales con botón X
    document.querySelectorAll('[data-modal-close]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const modal = e.target.closest('[data-modal]');
            if (modal) {
                hideModal(modal.id);
            }
        });
    });

    // Cerrar modales con backdrop
    document.querySelectorAll('[data-modal]').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                hideModal(modal.id);
            }
        });
    });

    // Abrir modales con botón
    document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const modalId = btn.dataset.modalToggle;
            showModal(modalId);
        });
    });
}

// Inicializar al cargar el DOM
document.addEventListener('DOMContentLoaded', initAdminEvents);
