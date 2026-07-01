document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('[data-sidebar-toggle]');
    const backdrop = document.querySelector('[data-sidebar-backdrop]');

    if (!sidebar || !toggle || !backdrop) {
        return;
    }

    const setOpen = (isOpen) => {
        sidebar.classList.toggle('active-sidebar', isOpen);
        backdrop.classList.toggle('active', isOpen);
        document.body.classList.toggle('sidebar-open', isOpen);
        toggle.setAttribute('aria-expanded', String(isOpen));
    };

    toggle.addEventListener('click', () => {
        setOpen(!sidebar.classList.contains('active-sidebar'));
    });

    backdrop.addEventListener('click', () => setOpen(false));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setOpen(false);
        }
    });

    // Actions for solicitud cards: approve / delete
    document.body.addEventListener('click', function(e) {
        const approveBtn = e.target.closest('.btn-confirm-delivery');
        const deleteBtn = e.target.closest('.btn-reject-delivery');

        if (approveBtn) {
            const card = approveBtn.closest('.match-card');
            if (!card) return;
            const id = card.dataset.id;
            if (!id) return;
            if (!confirm('¿Confirmas aprobar y marcar como entregada la solicitud #' + id + '?')) return;
            fetch('../consultas_php/admin/procesar_solicitud_ajax.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'approve', id: id })
            }).then(r => r.json()).then(data => {
                if (data.ok) {
                    // Solicitud aprobada: quitarla de la lista de pendientes
                    card.remove();
                } else {
                    alert('Error: ' + (data.error || 'no se pudo procesar'));
                }
            }).catch(err => { alert('Error de red'); console.error(err); });
        }

        if (deleteBtn) {
            const card = deleteBtn.closest('.match-card');
            if (!card) return;
            const id = card.dataset.id;
            if (!id) return;
            if (!confirm('¿Eliminar la solicitud #' + id + '? Esta acción no se puede deshacer.')) return;
            fetch('../consultas_php/admin/procesar_solicitud_ajax.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'delete', id: id })
            }).then(r => r.json()).then(data => {
                if (data.ok) {
                    card.remove();
                } else {
                    alert('Error: ' + (data.error || 'no se pudo borrar'));
                }
            }).catch(err => { alert('Error de red'); console.error(err); });
        }
    });
});
