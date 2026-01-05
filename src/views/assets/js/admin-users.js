/**
 * Application Livraison - Admin User Management JS
 */

document.addEventListener('DOMContentLoaded', () => {

    // Mock Users
    let users = [
        { id: 101, name: 'Jean Dupont', email: 'jean@mail.com', role: 'client', status: 'active', joined: '12/12/2024' },
        { id: 102, name: 'Pierre Livreur', email: 'pierre@delivery.com', role: 'livreur', status: 'active', joined: '15/12/2024' },
        { id: 103, name: 'Marie Cura', email: 'marie@mail.com', role: 'client', status: 'banned', joined: '01/12/2024' },
        { id: 104, name: 'SpeedX Express', email: 'contact@speedx.fr', role: 'livreur', status: 'pending', joined: 'Aujourd\'hui' },
        { id: 999, name: 'Admin User', email: 'admin@speed.com', role: 'admin', status: 'active', joined: '01/01/2024' },
    ];

    const tableBody = document.getElementById('users-table-body');
    const searchInput = document.getElementById('userSearch');

    if (tableBody) {
        renderUsers(users);

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                const filtered = users.filter(u =>
                    u.name.toLowerCase().includes(term) || u.email.toLowerCase().includes(term)
                );
                renderUsers(filtered);
            });
        }
    }

    /* --- FUNCTIONS --- */

    function renderUsers(list) {
        if (list.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">Aucun utilisateur trouvé.</td></tr>';
            return;
        }

        tableBody.innerHTML = list.map(user => `
            <tr>
                <td class="fw-bold">#${user.id}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle-sm bg-light text-dark me-2 small fw-bold">${getInitials(user.name)}</div>
                        <div>
                            <div class="fw-bold text-dark">${user.name}</div>
                            <small class="text-muted">${user.email}</small>
                        </div>
                    </div>
                </td>
                <td>${getRoleBadge(user.role)}</td>
                <td>${user.joined}</td>
                <td>${getStatusLabel(user.status)}</td>
                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                            <li><h6 class="dropdown-header">Actions</h6></li>
                            <li><a class="dropdown-item small" href="#" onclick="openUserModal(${user.id})"><i class="bi bi-pencil me-2"></i>Modifier</a></li>
                            ${getActionItems(user)}
                        </ul>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function getInitials(name) {
        return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
    }

    function getRoleBadge(role) {
        const cls = {
            'admin': 'bg-dark text-white',
            'client': 'bg-primary-custom text-white',
            'livreur': 'bg-info text-dark'
        };
        const icon = {
            'admin': 'bi-shield-check',
            'client': 'bi-person',
            'livreur': 'bi-scooter'
        };
        return `<span class="badge ${cls[role] || 'bg-secondary'}"><i class="bi ${icon[role]} me-1"></i>${role}</span>`;
    }

    function getStatusLabel(status) {
        if (status === 'active') return '<span class="badge bg-success-light text-success rounded-pill"><i class="bi bi-circle-fill" style="font-size:5px; vertical-align:middle; margin-right:4px;"></i>Actif</span>';
        if (status === 'banned') return '<span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">Banni</span>';
        if (status === 'pending') return '<span class="badge bg-warning bg-opacity-10 text-dark rounded-pill">En attente</span>';
        return status;
    }

    function getActionItems(user) {
        if (user.role === 'admin') return '<li><a class="dropdown-item disabled small" href="#">Aucune action</a></li>';

        let html = '';
        if (user.status === 'active') {
            html += `<li><a class="dropdown-item small text-danger" href="#" onclick="toggleStatus(${user.id}, 'banned')"><i class="bi bi-ban me-2"></i>Bannir</a></li>`;
        } else {
            html += `<li><a class="dropdown-item small text-success" href="#" onclick="toggleStatus(${user.id}, 'active')"><i class="bi bi-check-lg me-2"></i>Activer</a></li>`;
        }

        html += `<li><hr class="dropdown-divider"></li>`;
        html += `<li><a class="dropdown-item small" href="#" onclick="changeRole(${user.id})"><i class="bi bi-person-gear me-2"></i>Changer Rôle</a></li>`;

        return html;
    }

    // Windows global functions
    window.toggleStatus = (id, newStatus) => {
        const u = users.find(x => x.id === id);
        if (u) {
            u.status = newStatus;
            renderUsers(users); // Re-render
            showToast(`Utilisateur ${u.name} est maintenant ${newStatus}.`, 'success');
        }
    };

    window.changeRole = (id) => {
        const u = users.find(x => x.id === id);
        if (u) {
            const roles = ['client', 'livreur', 'admin'];
            const currentIdx = roles.indexOf(u.role);
            const nextRole = roles[(currentIdx + 1) % roles.length];
            u.role = nextRole;
            renderUsers(users);
            showToast(`Rôle de ${u.name} changé en ${nextRole}.`, 'success');
        }
    };

    // Modal & Form Logic
    const userModal = new bootstrap.Modal(document.getElementById('userModal'));

    window.openUserModal = (id = null) => {
        const modalTitle = document.getElementById('userModalLabel');
        const userIdInput = document.getElementById('userId');
        const userNameInput = document.getElementById('userName');
        const userEmailInput = document.getElementById('userEmail');
        const userRoleInput = document.getElementById('userRole');

        if (id) {
            // Edit Mode
            const u = users.find(x => x.id === id);
            if (!u) return;

            modalTitle.innerText = "Modifier l'utilisateur";
            userIdInput.value = u.id;
            userNameInput.value = u.name;
            userEmailInput.value = u.email;
            userRoleInput.value = u.role;
        } else {
            // Add Mode
            modalTitle.innerText = "Ajouter un utilisateur";
            userIdInput.value = '';
            // Reset form
            document.getElementById('userForm').reset();
        }

        userModal.show();
    };

    window.saveUser = () => {
        const id = document.getElementById('userId').value;
        const name = document.getElementById('userName').value;
        const email = document.getElementById('userEmail').value;
        const role = document.getElementById('userRole').value;

        if (!name || !email) {
            alert("Veuillez remplir tous les champs obligatoires.");
            return;
        }

        if (id) {
            // Update existing
            const u = users.find(x => x.id == id);
            if (u) {
                u.name = name;
                u.email = email;
                u.role = role;
                showToast(`Utilisateur ${name} modifié avec succès.`, 'success');
            }
        } else {
            // Create new
            const newId = Math.max(...users.map(u => u.id)) + 1;
            users.push({
                id: newId,
                name: name,
                email: email,
                role: role,
                status: 'active',
                joined: 'A l\'instant'
            });
            showToast(`Utilisateur ${name} ajouté avec succès.`, 'success');
        }

        renderUsers(users);
        userModal.hide();
    };
});
