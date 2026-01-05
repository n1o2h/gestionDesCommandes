/**
 * Application Livraison - Deliverer Order Details JS
 */

document.addEventListener('DOMContentLoaded', () => {

    // Competitor Offers (Blind - No Price shown)
    const competitors = [
        { id: 1, name: 'Livreur A.', rating: 4.5, time: '20 min', vehicle: 'Scooter' },
        { id: 2, name: 'Livreur B.', rating: 4.8, time: '1h', vehicle: 'Voiture' },
        { id: 3, name: 'Livreur C.', rating: 3.9, time: '45 min', vehicle: 'Vélo' }
    ];

    const competitorsList = document.getElementById('competitors-list');
    const offerForm = document.getElementById('offerForm');

    if (competitorsList) {
        renderCompetitors(competitors);
    }

    if (offerForm) {
        offerForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const submitBtn = offerForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Simulate sending offer
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Envoi...';
            submitBtn.disabled = true;

            setTimeout(() => {
                // alert('Votre offre a été envoyée avec succès ! Le client recevra une notification.');
                showToast('Offre envoyée ! Le client a été notifié.', 'success');
                window.location.href = 'dashboard-livreur.html';
            }, 1500);
        });
    }

    /* --- FUNCTIONS --- */

    function renderCompetitors(list) {
        if (list.length === 0) {
            competitorsList.innerHTML = '<div class="text-muted small">Aucune offre pour le moment. Soyez le premier !</div>';
            return;
        }

        competitorsList.innerHTML = `
            <p class="small text-muted mb-3"><i class="bi bi-eye-slash me-1"></i> Les prix des autres livreurs sont masqués.</p>
            <div class="list-group">
                ${list.map(c => `
                    <div class="list-group-item d-flex justify-content-between align-items-center bg-light border-0 mb-2 rounded">
                        <div>
                            <span class="fw-bold text-dark">${c.name}</span>
                            <div class="small text-muted">
                                <i class="bi bi-star-fill text-warning" style="font-size:0.75rem"></i> ${c.rating} • 
                                ${c.vehicle} • ${c.time}
                            </div>
                        </div>
                        <span class="badge bg-secondary opacity-50"><i class="bi bi-lock-fill"></i> Prix caché</span>
                    </div>
                `).join('')}
            </div>
        `;
    }

});
