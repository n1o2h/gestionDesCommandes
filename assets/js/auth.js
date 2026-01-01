/**
 * Application Livraison - Auth JS
 * Handles Login and Register form validation and simulation
 */

document.addEventListener('DOMContentLoaded', () => {

    /* --- LOGIN FORM HANDLING --- */
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleLogin(loginForm);
        });
    }

    /* --- REGISTER FORM HANDLING --- */
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleRegister(registerForm);
        });

        // Password Strength Real-time check
        const passInput = document.getElementById('password');
        if (passInput) {
            passInput.addEventListener('input', function () {
                checkPasswordStrength(this.value);
            });
        }
    }

    /* --- ACTIONS --- */

    function handleLogin(form) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const role = document.getElementById('roleSelector') ? document.getElementById('roleSelector').value : 'client';
        const submitBtn = form.querySelector('button[type="submit"]');

        if (!validateEmail(email)) {
            showError('email', 'Email invalide.');
            return;
        }

        simulateLoading(submitBtn, 'Connexion...', () => {
            // Simulate redirection
            let targetPage = 'index.html';
            switch (role) {
                case 'client': targetPage = 'dashboard-client.html'; break;
                case 'livreur': targetPage = 'dashboard-livreur.html'; break;
                case 'admin': targetPage = 'dashboard-admin.html'; break;
            }
            showToast(`Bienvenue ${role} ! Redirection...`, 'success');
            window.location.href = targetPage;
        });
    }

    function handleRegister(form) {
        const name = document.getElementById('fullname').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPass = document.getElementById('confirmPassword').value;
        const role = document.querySelector('input[name="role"]:checked').value;
        const submitBtn = form.querySelector('button[type="submit"]');

        // Validation
        if (name.length < 3) {
            showError('fullname', 'Le nom est trop court.');
            return;
        }
        if (!validateEmail(email)) {
            showError('email', 'Email invalide.');
            return;
        }
        if (password.length < 6) {
            showError('password', 'Le mot de passe doit faire 6 caractères min.');
            return;
        }
        if (password !== confirmPass) {
            showError('confirmPassword', 'Les mots de passe ne correspondent pas.');
            return;
        }

        simulateLoading(submitBtn, 'Création...', () => {
            showToast(`Compte créé ! Veuillez vous connecter.`, 'success');
            window.location.href = 'login.html';
        });
    }

    /* --- UTILS --- */

    function simulateLoading(btn, text, callback) {
        const originalText = btn.innerHTML;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${text}`;
        btn.disabled = true;
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            callback();
        }, 1500);
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(email).toLowerCase());
    }

    function showError(fieldId, message) {
        const input = document.getElementById(fieldId);
        const parent = input.closest('.input-group-custom') || input.parentElement;

        // Remove old error
        const existing = parent.querySelector('.invalid-feedback-custom');
        if (existing) existing.remove();

        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback-custom text-danger small mt-1 ms-2';
        errorDiv.innerText = message;
        parent.appendChild(errorDiv);

        input.classList.add('border-danger');

        input.addEventListener('input', () => {
            input.classList.remove('border-danger');
            if (errorDiv) errorDiv.remove();
        }, { once: true });
    }

    function checkPasswordStrength(password) {
        const bar = document.getElementById('password-strength-bar');
        const text = document.getElementById('password-strength-text');
        if (!bar || !text) return;

        let strength = 0;
        if (password.length > 5) strength++;
        if (password.length > 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        // Width & Color
        let width = '0%';
        let color = '#dc3545'; // red
        let msg = 'Trop court';

        switch (strength) {
            case 0:
            case 1: width = '20%'; color = '#dc3545'; msg = 'Faible'; break;
            case 2: width = '40%'; color = '#ffc107'; msg = 'Moyen'; break;
            case 3: width = '60%'; color = '#fd7e14'; msg = 'Correct'; break;
            case 4: width = '80%'; color = '#198754'; msg = 'Fort'; break;
            case 5: width = '100%'; color = '#0d6efd'; msg = 'Excellent'; break;
        }

        if (password.length === 0) {
            width = '0%';
            msg = '';
        }

        bar.style.width = width;
        bar.style.backgroundColor = color;
        text.innerText = msg;
        text.style.color = color;
    }
});
