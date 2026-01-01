/**
 * Application Livraison - Create Order JS
 */

document.addEventListener('DOMContentLoaded', () => {

    // Elements
    const form = document.getElementById('createOrderForm');
    const previewBtn = document.getElementById('btnPreview');
    const submitBtn = document.getElementById('btnSubmit'); // Real submit
    const modalPreview = new bootstrap.Modal(document.getElementById('previewModal'));

    // Preview Content Elements
    const pPickup = document.getElementById('p-pickup');
    const pDropoff = document.getElementById('p-dropoff');
    const pDesc = document.getElementById('p-desc');
    const pOptions = document.getElementById('p-options');

    // Validation & Preview Logic
    if (previewBtn) {
        previewBtn.addEventListener('click', () => {
            if (validateForm()) {
                fillPreview();
                modalPreview.show();
            }
        });
    }

    if (submitBtn) {
        submitBtn.addEventListener('click', () => {
            // Simulate API Call
            const btnOriginal = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Envoi...';
            submitBtn.disabled = true;

            setTimeout(() => {
                showToast('Votre commande a été publiée avec succès !', 'success');
                window.location.href = 'dashboard-client.html';
            }, 1500);
        });
    }

    /* --- FUNCTIONS --- */

    function validateForm() {
        let isValid = true;

        // Simple Required Check for now
        const requiredIds = ['pickupAddress', 'dropoffAddress', 'description'];

        requiredIds.forEach(id => {
            const el = document.getElementById(id);
            if (!el.value.trim()) {
                el.classList.add('is-invalid');
                isValid = false;

                // Remove error on input
                el.addEventListener('input', () => el.classList.remove('is-invalid'), { once: true });
            } else {
                el.classList.remove('is-invalid');
            }
        });

        return isValid;
    }

    function fillPreview() {
        pPickup.innerText = document.getElementById('pickupAddress').value;
        pDropoff.innerText = document.getElementById('dropoffAddress').value;
        pDesc.innerText = document.getElementById('description').value;

        // Options
        let options = [];
        if (document.getElementById('optFragile').checked) options.push('Fragile');
        if (document.getElementById('optExpress').checked) options.push('Express');

        if (options.length > 0) {
            pOptions.innerHTML = options.map(o => `<span class="badge bg-primary-custom me-1">${o}</span>`).join('');
        } else {
            pOptions.innerHTML = '<span class="text-muted small">Aucune option</span>';
        }
    }

});
