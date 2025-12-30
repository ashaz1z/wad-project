document.addEventListener('DOMContentLoaded', () => {
    // Intersection Observer for fade-in animations on scroll
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Only animate once
            }
        });
    }, observerOptions);

    const fadeElements = document.querySelectorAll('.fade-in, .main-content, .dashboard-main, .login-container');
    fadeElements.forEach(el => {
        el.classList.add('fade-in'); // Ensure class exists
        observer.observe(el);
    });

    // Stagger animation for grids (Cards pop in one by one)
    const grids = document.querySelectorAll('.items-grid, .analytics-grid, .features-grid');
    grids.forEach(grid => {
        const cards = grid.querySelectorAll('.card, .feature-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`; // 100ms delay per item
            card.classList.add('fade-in-up');
        });
    });

    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            // Only prevent default if href is not just "#"
            if (this.getAttribute('href') !== '#') {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // AJAX Delete Handler
    document.addEventListener('click', function(e) {
        const link = e.target.closest('.delete-btn');
        if (link) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to delete this?')) {
                // Append ajax=1 to the URL to tell PHP to return JSON
                const url = link.getAttribute('href') + '&ajax=1';
                
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Fade out and remove the row
                            const row = link.closest('tr');
                            if (row) {
                                row.style.transition = 'opacity 0.3s ease';
                                row.style.opacity = '0';
                                setTimeout(() => row.remove(), 300);
                            }
                        } else {
                            alert('Error deleting item.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while trying to delete.');
                    });
            }
        }
    });
});

// Dashboard Charts Initialization
window.initDashboardCharts = function(spendingLabels, spendingValues, progressLabels, progressValues) {
    const ctxSpending = document.getElementById('spendingChart');
    const ctxProgress = document.getElementById('progressChart');

    if (ctxSpending && typeof Chart !== 'undefined') {
            new Chart(ctxSpending.getContext('2d'), {
            type: 'line',
            data: {
                labels: spendingLabels,
                datasets: [{
                    label: 'Daily Spending ($)',
                    data: spendingValues,
                    borderColor: '#2e7d32',
                    backgroundColor: 'rgba(46, 125, 50, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } }
            }
        });
    }

    if (ctxProgress && typeof Chart !== 'undefined') {
        new Chart(ctxProgress.getContext('2d'), {
            type: 'line',
            data: {
                labels: progressLabels,
                datasets: [{
                    label: 'Weight (kg)',
                    data: progressValues,
                    borderColor: '#2e7d32',
                    backgroundColor: 'rgba(46, 125, 50, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } }
            }
        });
    }
};