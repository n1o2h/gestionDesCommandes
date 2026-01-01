/**
 * Application Livraison - Deliverer Dashboard JS
 */

document.addEventListener('DOMContentLoaded', () => {

    /* --- MOCK DATA --- */

    // Commandes Disponibles (Marketplace)
    const availableOrders = [
        { id: 'CMD-101', pickup: 'Paris 12', dropoff: 'Paris 04', dist: '3.5 km', price: '?', date: 'Aujourd\'hui', urgent: true },
        { id: 'CMD-102', pickup: 'Boulogne', dropoff: 'Issy', dist: '5.2 km', price: '?', date: 'Demain', urgent: false },
        { id: 'CMD-105', pickup: 'Versailles', dropoff: 'Paris 15', dist: '12 km', price: '?', date: '30/12', urgent: false },
    ];

    // Commandes en cours (Active)
    const activeDeliveries = [
        { id: 'CMD-099', pickup: 'Lyon Part-Dieu', dropoff: 'Lyon Bellecour', status: 'shipped', price: '18.00€' }
    ];

    // Offres en attente (Sent Offers)
    const myOffers = [
        { id: 'CMD-098', offerPrice: '25.00€', status: 'pending', date: 'Hier' }
    ];


    /* --- RENDERING --- */

    renderAvailable(availableOrders);
    renderActive(activeDeliveries);
    renderOffers(myOffers);


    function renderAvailable(orders) {
        const container = document.getElementById('available-orders-list');
        if (!container) return;

        if (orders.length === 0) {
            container.innerHTML = '<div class="text-muted text-center py-3">Aucune commande disponible.</div>';
            return;
        }

        container.innerHTML = orders.map(order => `
            <div class="card card-custom mb-3 border-0 shadow-sm animate-slide-in">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-light text-dark border">#${order.id}</span>
                        ${order.urgent ? '<span class="badge bg-danger rounded-pill"><i class="bi bi-lightning-fill"></i> Urgent</span>' : ''}
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                         <div>
                            <h6 class="mb-1 fw-bold"><i class="bi bi-geo-alt text-primary-custom me-1"></i> ${order.pickup} <i class="bi bi-arrow-right mx-2 text-muted"></i> ${order.dropoff}</h6>
                            <small class="text-muted"><i class="bi bi-signpost-2 me-1"></i>${order.dist} • ${order.date}</small>
                         </div>
                         <button class="btn btn-sm btn-outline-custom rounded-pill px-3" onclick="window.location.href='deliverer-order-details.html'">Voir</button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function renderActive(orders) {
        const container = document.getElementById('active-orders-list');
        if (!container) return;

        if (orders.length === 0) {
            container.innerHTML = '<div class="text-muted small fst-italic">Aucune livraison en cours.</div>';
            return;
        }

        container.innerHTML = orders.map(order => `
            <div class="alert alert-info border-0 shadow-sm d-flex justify-content-between align-items-center mb-2">
                <div>
                     <strong>#${order.id}</strong> <small class="mx-1">•</small> ${order.pickup}
                     <div class="small mt-1"><span class="badge bg-info text-white">En cours de livraison</span></div>
                </div>
                <button class="btn btn-sm btn-light text-primary-custom fw-bold" onclick="window.location.href='deliverer-order-details.html'">Gérer</button>
            </div>
        `).join('');
    }

    function renderOffers(offers) {
        const container = document.getElementById('my-offers-list');
        if (!container) return;

        if (offers.length === 0) container.innerHTML = '<div class="text-muted small">Aucune offre en attente.</div>';

        container.innerHTML = offers.map(offer => `
            <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                 <div>
                    <span class="fw-bold text-dark">#${offer.id}</span>
                    <span class="text-muted small ms-2">Offre: ${offer.offerPrice}</span>
                 </div>
                 <span class="badge bg-warning text-dark small">En attente</span>
            </div>
        `).join('');
    }

});
