/**
 * Application Livraison - Client Orders List JS
 */

document.addEventListener('DOMContentLoaded', () => {

    // Mock Data
    const myOrders = [
        { id: 'CMD-005', date: '31/12/2024', pickup: 'Paris', dropoff: 'Lyon', status: 'created', offers: 0, price: '-' },
        { id: 'CMD-004', date: '31/12/2024', pickup: 'Bordeaux', dropoff: 'Toulouse', status: 'pending_offers', offers: 3, price: '-' },
        { id: 'CMD-002', date: '30/12/2024', pickup: 'Lille', dropoff: 'Lens', status: 'processing', offers: 1, price: '15.00€' },
        { id: 'CMD-001', date: '28/12/2024', pickup: 'Marseille', dropoff: 'Nice', status: 'shipped', offers: 1, price: '45.00€' },
        { id: 'CMD-000', date: '20/12/2024', pickup: 'Strasbourg', dropoff: 'Metz', status: 'completed', offers: 1, price: '30.00€' },
        { id: 'CMD-XXX', date: '15/12/2024', pickup: 'Nantes', dropoff: 'Rennes', status: 'cancelled', offers: 0, price: '-' },
    ];

    const listContainer = document.getElementById('orders-list');
    const filterSelect = document.getElementById('statusFilter');

    if (listContainer) {
        renderOrders(myOrders);

        // Filter Logic
        if (filterSelect) {
            filterSelect.addEventListener('change', (e) => {
                const filter = e.target.value;
                if (filter === 'all') {
                    renderOrders(myOrders);
                } else {
                    const filtered = myOrders.filter(o => o.status === filter);
                    renderOrders(filtered);
                }
            });
        }
    }

    /* --- RENDER FUNCTIONS --- */

    function renderOrders(ordersData) {
        if (ordersData.length === 0) {
            listContainer.innerHTML = `
                <div class="text-center py-5">
                    <div class="mb-3 text-muted"><i class="bi bi-inbox fs-1"></i></div>
                    <h5>Aucune commande trouvée</h5>
                </div>`;
            return;
        }

        listContainer.innerHTML = ordersData.map(order => `
            <div class="card card-custom mb-3 border-0 shadow-sm animate-slide-in">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Icon & Info -->
                        <div class="col-md-4 mb-3 mb-md-0 d-flex align-items-center">
                            <div class="icon-box-sm rounded bg-light me-3 text-muted" style="width:50px; height:50px; font-size:1.5rem;">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Commande #${order.id}</h6>
                                <span class="small text-muted"><i class="bi bi-calendar3 me-1"></i>${order.date}</span>
                            </div>
                        </div>

                        <!-- Route & Price -->
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="small">
                                <div class="mb-1"><span class="badge bg-light text-dark border me-1">Départ</span> ${order.pickup}</div>
                                <div><span class="badge bg-light text-dark border me-1">Arrivée</span> ${order.dropoff}</div>
                            </div>
                        </div>

                        <!-- Status & Offers -->
                        <div class="col-md-3 mb-3 mb-md-0 text-center text-md-start">
                            <div class="mb-2">${getStatusBadge(order.status)}</div>
                            ${order.offers > 0 && order.status === 'pending_offers'
                ? `<span class="badge bg-primary-custom rounded-pill animate-pulse">${order.offers} nouvelles offres !</span>`
                : ''}
                        </div>

                        <!-- Actions -->
                        <div class="col-md-2 text-md-end d-flex flex-md-column justify-content-center gap-2">
                             ${getActionButtons(order)}
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function getStatusBadge(status) {
        const badges = {
            'created': '<span class="badge bg-secondary">Créée</span>',
            'pending_offers': '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Offres en attente</span>',
            'processing': '<span class="badge bg-info text-dark">Traitement</span>',
            'shipped': '<span class="badge bg-primary text-white"><i class="bi bi-truck me-1"></i>Expédiée</span>',
            'completed': '<span class="badge bg-success"><i class="bi bi-check-all me-1"></i>Terminée</span>',
            'cancelled': '<span class="badge bg-danger">Annulée</span>'
        };
        return badges[status] || '<span class="badge bg-secondary">Inconnu</span>';
    }

    function getActionButtons(order) {
        let buttons = `<button class="btn btn-sm btn-outline-custom w-100" onclick="window.location.href='order-details.html'">Détails</button>`;

        // Logic for Modifiable / Cancellable
        if (['created', 'pending_offers'].includes(order.status)) {
            buttons += `<button class="btn btn-sm btn-light text-muted border w-100" onclick="showToast('Fonctionnalité Modification à venir', 'info')"><i class="bi bi-pencil-square"></i></button>`;
            buttons += `<button class="btn btn-sm btn-outline-danger w-100" onclick="confirmCancel('${order.id}')"><i class="bi bi-x-circle"></i></button>`;
        }

        // Soft Delete for Finished/Cancelled
        if (['completed', 'cancelled'].includes(order.status)) {
            buttons += `<button class="btn btn-sm btn-light text-danger w-100" onclick="confirmDelete('${order.id}')" title="Supprimer"><i class="bi bi-trash"></i></button>`;
        }

        // Validation Button for Shipped (Client Validates Delivery)
        if (order.status === 'shipped') {
            buttons += `<button class="btn btn-sm btn-success text-white w-100" onclick="showToast('Réception validée !', 'success')">Reçu !</button>`;
        }

        return `<div class="d-flex gap-1">${buttons}</div>`;
    }

    // Global Functions for OnClick access
    window.confirmCancel = (id) => {
        if (confirm("Êtes-vous sûr de vouloir annuler cette commande ? Vous ne recevrez plus d'offres.")) {
            showToast(`Commande ${id} annulée.`, 'success');
            // Reload or re-render logic here
        }
    };

    window.confirmDelete = (id) => {
        if (confirm("Supprimer cette commande de votre historique ?")) {
            // Remove element logic
            showToast(`Commande ${id} supprimée.`, 'info');
        }
    }
});
