/**
 * Application Livraison - Main JS
 */

document.addEventListener('DOMContentLoaded', () => {
    console.log('SpeedDelivery App Loaded');

    // Sticky Navbar on scroll
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow-sm');
            navbar.classList.add('bg-white');
        } else {
            navbar.classList.remove('shadow-sm');
        }
    });

    // Initialize Bootstrap Tooltips (if used)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});

/* --- GLOBAL TOAST NOTIFICATIONS --- */
window.showToast = (message, type = 'info') => {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast-custom ${type}`;

    let icon = 'bi-info-circle-fill';
    if (type === 'success') icon = 'bi-check-circle-fill text-success';
    if (type === 'error') icon = 'bi-exclamation-triangle-fill text-danger';

    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi ${icon} me-3 fs-5"></i>
            <div>
                <span class="fw-bold d-block text-capitalize">${type === 'info' ? 'Information' : type}</span>
                <span class="small text-muted">${message}</span>
            </div>
        </div>
        <button onclick="this.parentElement.remove()" class="btn-close ms-2" style="font-size: 0.8rem;"></button>
    `;

    container.appendChild(toast);

    // Auto remove
    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.5s forwards';
        setTimeout(() => toast.remove(), 500);
    }, 4000);
};
