/**
 * Application Livraison - Client Dashboard JS
 */

document.addEventListener('DOMContentLoaded', () => {
    console.log('Client Dashboard Loaded');

    // Simulate User Name
    const userNameElement = document.getElementById('user-name');
    if (userNameElement) {
        userNameElement.textContent = "Thomas Dupont";
    }

    // Mock Data for Orders
    const orders = [
        { id: 'CMD-001', date: '31/12/2024', pickup: 'Paris 15', dropoff: 'Paris 11', status: 'En attente', offerCount: 2, price: '-' },
        { id: 'CMD-002', date: '30/12/2024', pickup: 'Lyon', dropoff: 'Villeurbanne', status: 'En cours', offerCount: 1, price: '15.50€' },
        { id: 'CMD-003', date: '28/12/2024', pickup: 'Marseille', dropoff: 'Aix', status: 'Terminée', offerCount: 3, price: '22.00€' },
    ];

    // Mock Data for Notifications
    const notifications = [
        { id: 1, text: "Nouvelle offre pour CMD-001", time: "Il y a 5 min", type: "offer" },
        { id: 2, text: "Votre commande CMD-002 est en cours de livraison", time: "Il y a 2h", type: "status" },
        { id: 3, text: "Commande CMD-003 livrée avec succès", time: "Hier", type: "success" }
    ];

    // Render Recent Orders
    const ordersTableBody = document.getElementById('recent-orders-body');
    if (ordersTableBody) {
        ordersTableBody.innerHTML = orders.map(order => `
            <tr>
                <td class="fw-bold text-primary-custom">#${order.id}</td>
                <td>${order.date}</td>
                <td>
                    <div class="d-flex flex-column small">
                        <span><i class="bi bi-geo-alt text-muted me-1"></i>${order.pickup}</span>
                        <span><i class="bi bi-arrow-down text-muted me-1"></i>${order.dropoff}</span>
                    </div>
                </td>
                <td>${getStatusBadge(order.status)}</td>
                <td class="text-center">
                    ${order.offerCount > 0
                ? `<span class="badge bg-light text-dark border border-secondary">${order.offerCount} offre(s)</span>`
                : '<span class="text-muted small">Aucune</span>'}
                </td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-custom rounded-pill" onclick="window.location.href='order-details.html'">Détails</button>
                </td>
            </tr>
        `).join('');
    }

    // Render Notifications
    const notifList = document.getElementById('notification-list');
    if (notifList) {
        notifList.innerHTML = notifications.map(notif => `
            <div class="list-group-item list-group-item-action border-0 mb-2 rounded shadow-sm d-flex align-items-center">
                <div class="icon-box-sm ${getNotifColor(notif.type)} me-3">
                    <i class="bi ${getNotifIcon(notif.type)}"></i>
                </div>
                <div class="w-100">
                    <div class="d-flex w-100 justify-content-between">
                        <small class="mb-1 fw-bold text-dark">${notif.text}</small>
                        <small class="text-muted" style="font-size: 0.75rem;">${notif.time}</small>
                    </div>
                </div>
            </div>
        `).join('');
    }

    /* --- HELPERS --- */
    function getStatusBadge(status) {
        switch (status) {
            case 'En attente': return '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>En attente</span>';
            case 'En cours': return '<span class="badge bg-info text-white"><i class="bi bi-truck me-1"></i>En cours</span>';
            case 'Terminée': return '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Terminée</span>';
            default: return '<span class="badge bg-secondary">Inconnu</span>';
        }
    }

    function getNotifColor(type) {
        switch (type) {
            case 'offer': return 'bg-purple-light text-purple';
            case 'status': return 'bg-info-light text-info';
            case 'success': return 'bg-success-light text-success';
            default: return 'bg-light text-muted';
        }
    }

    function getNotifIcon(type) {
        switch (type) {
            case 'offer': return 'bi-tag-fill';
            case 'status': return 'bi-bicycle';
            case 'success': return 'bi-check-lg';
            default: return 'bi-bell';
        }
    }
});
