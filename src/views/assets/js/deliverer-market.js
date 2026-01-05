/**
 * Application Livraison - Deliverer Marketplace JS
 */

document.addEventListener('DOMContentLoaded', () => {

    // Mock Data: Orders waiting for offers
    const marketOrders = [
        {
            id: 'CMD-104',
            pickup: 'Paris 08, Champs-Élysées',
            dropoff: 'Paris 17, Ternes',
            distance: '2.4 km',
            desc: 'Documents urgents (Enveloppe A4)',
            date: 'À l\'instant',
            isNew: true,
            isUrgent: true
        },
        {
            id: 'CMD-102',
            pickup: 'Boulogne-Billancourt',
            dropoff: 'Issy-les-Moulineaux',
            distance: '5.2 km',
            desc: 'Petit colis (Chaussures)',
            date: 'Il y a 15 min',
            isNew: true,
            isUrgent: false
        },
        {
            id: 'CMD-101',
            pickup: 'Versailles',
            dropoff: 'Paris 15',
            distance: '14 km',
            desc: 'Matériel informatique (Écran)',
            date: 'Il y a 2h',
            isNew: false,
            isUrgent: false
        },
        {
            id: 'CMD-099',
            pickup: 'Neuilly-sur-Seine',
            dropoff: 'La Défense',
            distance: '1.8 km',
            desc: 'Repas Traiteur',
            date: 'Il y a 3h',
            isNew: false,
            isUrgent: true
        }
    ];

    const listContainer = document.getElementById('market-list');
    const sortSelect = document.getElementById('sortOrder');

    if (listContainer) {
        renderMarket(marketOrders);

        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                const sortType = e.target.value;
                let sorted = [...marketOrders];

                if (sortType === 'recent') {
                    // Mock sorting by keeping original order for now or reversing
                } else if (sortType === 'urgent') {
                    sorted = sorted.filter(o => o.isUrgent);
                } else if (sortType === 'distance') {
                    sorted.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));
                }

                renderMarket(sorted);
            });
        }
    }

    /* --- RENDERING --- */

    function renderMarket(orders) {
        if (orders.length === 0) {
            listContainer.innerHTML = `
                <div class="text-center py-5">
                    <div class="mb-3 text-muted opacity-50"><i class="bi bi-search fs-1"></i></div>
                    <h5>Aucune commande ne correspond à vos critères</h5>
                </div>
            `;
            return;
        }

        listContainer.innerHTML = orders.map(order => `
            <div class="col-md-6 mb-4">
                <div class="card card-custom h-100 border-0 shadow-sm animate-slide-in">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                ${order.isNew ? '<span class="badge bg-primary-custom mb-2 me-1">Nouveau</span>' : ''}
                                ${order.isUrgent ? '<span class="badge bg-danger mb-2"><i class="bi bi-lightning-fill"></i> Urgent</span>' : ''}
                                <h6 class="fw-bold text-dark mt-1">#${order.id}</h6>
                            </div>
                            <small class="text-muted">${order.date}</small>
                        </div>

                        <div class="timeline-simple mb-3 ps-3 border-start border-2">
                             <div class="mb-2 position-relative">
                                <div class="position-absolute start-0 top-0 translate-middle rounded-circle bg-dark" style="width: 8px; height: 8px; margin-left: -1px; margin-top: 6px;"></div>
                                <span class="d-block text-truncate fw-medium">${order.pickup}</span>
                            </div>
                            <div class="position-relative">
                                <div class="position-absolute start-0 top-0 translate-middle rounded-circle bg-dark" style="width: 8px; height: 8px; margin-left: -1px; margin-top: 6px;"></div>
                                <span class="d-block text-truncate fw-medium">${order.dropoff}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center text-muted small mb-4 bg-light p-2 rounded">
                            <i class="bi bi-box-seam me-2"></i> ${order.desc}
                            <span class="mx-2">•</span>
                            <i class="bi bi-signpost-2 me-2"></i> ${order.distance}
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-outline-custom" onclick="window.location.href='deliverer-order-details.html'">
                                Voir détails & Offrir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }
});
