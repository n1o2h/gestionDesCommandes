/**
 * Application Livraison - Admin Dashboard JS
 */

document.addEventListener('DOMContentLoaded', () => {

    /* --- MOCK DATA --- */
    const stats = {
        created: 154,
        completed: 120,
        cancelled: 5,
        activeDeliverers: 42,
        offers: 350
    };

    // Chart Data
    const chartDataWeek = {
        labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
        data: [12, 19, 15, 25, 22, 30, 18],
        maxInfo: '30'
    };

    const chartDataMonth = {
        labels: ['S1', 'S2', 'S3', 'S4'],
        data: [120, 145, 110, 160],
        maxInfo: '160'
    };

    /* --- INIT --- */
    renderStats(stats);
    // Default render
    renderChart('ordersChart', chartDataWeek.labels, chartDataWeek.data, 'Commandes', '#6C63FF');
    renderRecentActivity();

    /* --- EVENTS --- */
    const chartFilter = document.getElementById('chartFilter');
    if (chartFilter) {
        chartFilter.addEventListener('change', (e) => {
            const val = e.target.value;
            if (val === 'week') {
                renderChart('ordersChart', chartDataWeek.labels, chartDataWeek.data, 'Commandes', '#6C63FF');
            } else if (val === 'month') {
                renderChart('ordersChart', chartDataMonth.labels, chartDataMonth.data, 'Commandes', '#0dcaf0');
            }
        });
    }

    /* --- FUNCTIONS --- */

    function renderStats(data) {
        document.getElementById('stat-created').innerText = data.created;
        document.getElementById('stat-completed').innerText = data.completed;
        document.getElementById('stat-cancelled').innerText = data.cancelled;
        document.getElementById('stat-deliverers').innerText = data.activeDeliverers;
    }

    // Improved Bar Chart Simulator
    function renderChart(elementId, labels, data, title, color) {
        const container = document.getElementById(elementId);
        if (!container) return;

        const maxVal = Math.max(...data);
        const steps = 5; // Y-axis steps

        let html = `
            <div class="d-flex h-100 w-100" style="min-height: 250px;">
                <!-- Y Axis -->
                <div class="d-flex flex-column justify-content-between align-items-end pe-2 text-muted small" style="width: 30px; border-right: 1px solid #eee;">
                    <span>${Math.ceil(maxVal)}</span>
                    <span>${Math.ceil(maxVal * 0.75)}</span>
                    <span>${Math.ceil(maxVal * 0.5)}</span>
                    <span>${Math.ceil(maxVal * 0.25)}</span>
                    <span>0</span>
                </div>
                
                <!-- Bars Area -->
                <div class="d-flex align-items-end justify-content-between flex-grow-1 ps-3 pb-3" style="border-bottom: 1px solid #eee;">
        `;

        data.forEach((value, index) => {
            const height = (value / maxVal) * 100;
            html += `
                <div class="d-flex flex-column align-items-center flex-grow-1">
                    <div class="w-50 rounded-top table-hover"
                         style="height: ${height}%; background-color: ${color}; opacity: 0.9; cursor: pointer; transition: all 0.3s ease; min-width: 15px;"
                         data-bs-toggle="tooltip" 
                         data-bs-placement="top"
                         title="${value} ${title}">
                    </div>
                </div>
            `;
        });

        html += `
                </div>
            </div>
            <!-- X Axis Labels -->
            <div class="d-flex justify-content-between ps-5 pe-2 mt-1 text-muted small">
        `;

        labels.forEach(label => {
            html += `<div class="text-center flex-grow-1">${label}</div>`;
        });

        html += `</div>`;

        container.innerHTML = html;

        // Init Tooltips
        var tooltipTriggerList = [].slice.call(container.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    }

    function renderRecentActivity() {
        const container = document.getElementById('recent-activity-list');
        if (!container) return;

        const activities = [
            { text: 'Nouvelle inscription livreur : Pierre', time: 'Il y a 5 min', icon: 'bi-person-plus', color: 'text-primary-custom' },
            { text: 'Commande #CMD-104 créée', time: 'Il y a 10 min', icon: 'bi-box-seam', color: 'text-success' },
            { text: 'Commande #CMD-099 livrée', time: 'Il y a 30 min', icon: 'bi-check-circle', color: 'text-info' },
            { text: 'Signalement : Retard #CMD-098', time: 'Il y a 1h', icon: 'bi-exclamation-triangle', color: 'text-warning' }
        ];

        container.innerHTML = activities.map(act => `
            <div class="d-flex align-items-center mb-3">
                <div class="me-3 ${act.color}"><i class="bi ${act.icon}"></i></div>
                <div>
                    <div class="small fw-bold text-dark">${act.text}</div>
                    <div class="text-muted" style="font-size: 0.7rem;">${act.time}</div>
                </div>
            </div>
         `).join('');
    }

});
