// Dashboard Charts
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js default configuration
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
    Chart.defaults.color = '#6b7280';
    
    // Pelanggaran per Kelas Chart
    const pelanggaranCtx = document.getElementById('pelanggaranChart');
    if (pelanggaranCtx) {
        new Chart(pelanggaranCtx, {
            type: 'bar',
            data: {
                labels: ['12 PPLG 1', '12 PPLG 2', '12 PPLG 3', '12 Pemasaran', '12 DKV', '12 Akuntansi 1', '12 Akuntansi 2', '12 Animasi'],
                datasets: [{
                    label: 'Jumlah Pelanggaran',
                    data: [5, 3, 7, 2, 4, 6, 1, 3],
                    backgroundColor: [
                        '#ef4444',
                        '#f97316',
                        '#eab308',
                        '#84cc16',
                        '#22c55e',
                        '#06b6d4',
                        '#3b82f6',
                        '#8b5cf6'
                    ],
                    borderColor: [
                        '#dc2626',
                        '#ea580c',
                        '#ca8a04',
                        '#65a30d',
                        '#16a34a',
                        '#0891b2',
                        '#2563eb',
                        '#7c3aed'
                    ],
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Prestasi per Kelas Chart
    const prestasiCtx = document.getElementById('prestasiChart');
    if (prestasiCtx) {
        new Chart(prestasiCtx, {
            type: 'doughnut',
            data: {
                labels: ['12 PPLG 1', '12 PPLG 2', '12 PPLG 3', '12 Pemasaran', '12 DKV', '12 Akuntansi 1', '12 Akuntansi 2', '12 Animasi'],
                datasets: [{
                    label: 'Jumlah Prestasi',
                    data: [12, 8, 15, 6, 10, 14, 9, 11],
                    backgroundColor: [
                        '#22c55e',
                        '#16a34a',
                        '#15803d',
                        '#166534',
                        '#14532d',
                        '#052e16',
                        '#84cc16',
                        '#65a30d'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }

    // Trend Chart
    const trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Pelanggaran',
                        data: [12, 8, 15, 10, 18, 14, 22, 16, 19, 13, 11, 9],
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Prestasi',
                        data: [8, 12, 10, 16, 14, 20, 18, 24, 22, 26, 28, 30],
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Konseling',
                        data: [5, 4, 7, 6, 8, 5, 9, 7, 6, 4, 3, 2],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }

    // Auto-refresh charts every 5 minutes
    setInterval(function() {
        // In a real application, you would fetch new data from the server
        console.log('Charts would be refreshed with new data');
    }, 300000); // 5 minutes

    // Add smooth animations
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Utility function to generate random data (for demo purposes)
function generateRandomData(count, min = 0, max = 100) {
    return Array.from({length: count}, () => Math.floor(Math.random() * (max - min + 1)) + min);
}

// Function to update chart data (can be called from external sources)
function updateChartData(chartId, newData) {
    const chart = Chart.getChart(chartId);
    if (chart) {
        chart.data.datasets[0].data = newData;
        chart.update('active');
    }
}