/**
 * Application Livraison - Order Details & Offers JS
 */

document.addEventListener('DOMContentLoaded', () => {

    // Mock Data for ONE specific order
    const currentOrder = {
        id: 'CMD-004',
        status: 'pending_offers', // created, pending_offers, processing
        date: '31/12/2024',
        pickup: 'Bordeaux',
        dropoff: 'Toulouse',
        desc: 'Instrument de musique (Guitare).',
        options: ['Fragile']
    };

    // Mock Offers
    const offers = [
        { id: 101, deliverer: 'Pierre L.', rating: 4.8, price: 25.00, vehicle: 'Berline', time: 'Demain 14h' },
        { id: 102, deliverer: 'SpeedX Express', rating: 4.5, price: 22.50, vehicle: 'Camionnette', time: 'Demain 18h' },
        { id: 103, deliverer: 'Jean-Marc', rating: 5.0, price: 28.00, vehicle: 'Moto', time: 'Aujourd\'hui 20h' }
    ];

    const offersContainer = document.getElementById('offers-list');
    const orderStatusBadge = document.getElementById('order-status-badge');

    // Init Page
    if (offersContainer) {
        renderOffers(offers);
        updateStatusBadge(currentOrder.status);
    }

    /* --- FUNCTIONS --- */

    function renderOffers(offersData) {
        if (offersData.length === 0) {
            offersContainer.innerHTML = '<div class="alert alert-light text-center">Aucune offre pour le moment.</div>';
            return;
        }

        offersContainer.innerHTML = offersData.map(offer => `
            <div class="col-md-6 mb-3">
                <div class="card card-custom h-100 border-0 shadow-sm offer-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle-sm bg-light text-primary-custom me-2 fw-bold" style="width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    ${getInitials(offer.deliverer)}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">${offer.deliverer}</h6>
                                    <small class="text-warning"><i class="bi bi-star-fill"></i> ${offer.rating}</small>
                                </div>
                            </div>
                            <h4 class="text-primary-custom fw-bold mb-0">${offer.price.toFixed(2)}€</h4>
                        </div>
                        
                        <div class="small text-muted mb-3">
                            <div class="d-flex align-items-center mb-1"><i class="bi bi-car-front me-2"></i> ${offer.vehicle}</div>
                            <div class="d-flex align-items-center"><i class="bi bi-clock me-2"></i> ${offer.time}</div>
                        </div>

                        <button class="btn btn-outline-custom w-100 btn-accept" onclick="acceptOffer(${offer.id}, '${offer.deliverer}')">
                            Accepter l'offre
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function updateStatusBadge(status) {
        if (!orderStatusBadge) return;
        if (status === 'pending_offers') {
            orderStatusBadge.innerHTML = '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>En attente d\'offres</span>';
        } else if (status === 'processing') {
            orderStatusBadge.innerHTML = '<span class="badge bg-info text-dark"><i class="bi bi-gear-wide-connected me-1"></i>En préparation</span>';
        } else {
            orderStatusBadge.innerHTML = '<span class="badge bg-secondary">' + status + '</span>';
        }
    }

    function getInitials(name) {
        return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
    }

    // Global Accept Function
    // Global Accept Function
    window.acceptOffer = (offerId, delivererName) => {
        // Direct acceptance without confirm (per user request to remove native popups)
        // In a real app, a custom modal would be better here.

        // Visual Updates
        // 1. Disable all buttons
        document.querySelectorAll('.btn-accept').forEach(btn => btn.disabled = true);

        // 2. Show Success
        const alertPlaceholder = document.getElementById('alert-placeholder');
        if (alertPlaceholder) {
            alertPlaceholder.innerHTML = `
                <div class="alert alert-success d-flex align-items-center shadow-sm animate-slide-in" role="alert">
                    <i class="bi bi-check-circle-fill flex-shrink-0 me-2 fs-4"></i>
                    <div>
                        <strong>Offre acceptée !</strong> La commande est maintenant en cours de traitement avec ${delivererName}.
                    </div>
                </div>
            `;
        }

        // 3. Update Status Badge
        updateStatusBadge('processing');

        // 4. Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // 5. Toast
        if (window.showToast) showToast(`Offre de ${delivererName} acceptée !`, 'success');
    }

});
