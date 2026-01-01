/**
 * Application Livraison - Notification History JS
 */

document.addEventListener('DOMContentLoaded', () => {

    // Mock Notifications
    const notifications = [
        { id: 1, type: 'order', title: 'Commande #CMD-104 Livrée', msg: 'Votre colis a bien été livré par Pierre.', date: 'Aujourd\'hui, 10:30', read: false },
        { id: 2, type: 'offer', title: 'Nouvelle offre reçue', msg: 'Jean-Marc vous propose 28€ pour votre course vers Toulouse.', date: 'Aujourd\'hui, 09:15', read: false },
        { id: 3, type: 'system', title: 'Bienvenue sur SpeedDelivery !', msg: 'N\'oubliez pas de compléter votre profil pour commander.', date: 'Hier, 18:00', read: true },
        { id: 4, type: 'promo', title: 'Promo : -50% aujourd\'hui', msg: 'Valable sur votre prochaine livraison avec le code SPEED50.', date: '30/12/2024', read: true },
        { id: 5, type: 'order', title: 'Commande #CMD-099 Prise en charge', msg: 'Le livreur est en route vers le point de retrait.', date: '28/12/2024', read: true },
    ];

    const listContainer = document.getElementById('notification-list');
    const filterBtns = document.querySelectorAll('.filter-btn');

    if (listContainer) {
        renderNotifications(notifications);

        // Filter Logic
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active state
                filterBtns.forEach(b => {
                    b.classList.remove('bg-primary-custom', 'text-white');
                    b.classList.add('bg-light', 'text-dark');
                });

                btn.classList.remove('bg-light', 'text-dark');
                btn.classList.add('bg-primary-custom', 'text-white');

                const filterType = btn.getAttribute('data-filter');
                if (filterType === 'all') {
                    renderNotifications(notifications);
                } else {
                    const filtered = notifications.filter(n => n.type === filterType);
                    renderNotifications(filtered);
                }
            });
        });
    }

    /* --- FUNCTIONS --- */

    function renderNotifications(list) {
        if (list.length === 0) {
            listContainer.innerHTML = `
                <div class="text-center py-5">
                    <div class="mb-3 text-muted opacity-50"><i class="bi bi-bell-slash fs-1"></i></div>
                    <h5>Aucune notification</h5>
                </div>
            `;
            return;
        }

        listContainer.innerHTML = list.map(notif => `
            <div class="card card-custom mb-3 border-0 shadow-sm animate-slide-in ${notif.read ? '' : 'border-start border-4 border-primary-custom'}">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="icon-box rounded-circle me-3 flex-shrink-0 d-flex align-items-center justify-content-center ${getIconStyle(notif.type)}" style="width:45px; height:45px; font-size: 1.2rem;">
                            <i class="bi ${getIcon(notif.type)}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="fw-bold mb-1 ${notif.read ? 'text-dark' : 'text-primary-custom'}">
                                    ${notif.title}
                                    ${!notif.read ? '<span class="badge bg-danger rounded-pill ms-2" style="font-size:0.6rem">Nouveau</span>' : ''}
                                </h6>
                                <small class="text-muted" style="font-size: 0.75rem;">${notif.date}</small>
                            </div>
                            <p class="mb-0 small text-secondary">${notif.msg}</p>
                        </div>
                         <div class="ms-3 dropdown">
                             <a href="#" class="text-muted" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                             <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                 <li><a class="dropdown-item small" href="#"><i class="bi bi-check2 me-2"></i>Marquer comme lu</a></li>
                                 <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i>Supprimer</a></li>
                             </ul>
                         </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function getIcon(type) {
        const map = {
            'order': 'bi-truck',         // Changed from box to truck for delivery context
            'offer': 'bi-currency-euro', // Changed from tag to euro for offers
            'system': 'bi-shield-check', // Changed from info to shield for system/security
            'promo': 'bi-gift-fill'      // Changed from percent to gift for promo
        };
        return map[type] || 'bi-bell-fill';
    }

    function getIconStyle(type) {
        const map = {
            'order': 'bg-primary-custom text-white',
            'offer': 'bg-success text-white',      // Changed to green/success for money/offers
            'system': 'bg-dark text-white',        // Dark for system
            'promo': 'bg-danger text-white'
        };
        return map[type] || 'bg-light text-dark';
    }

});
