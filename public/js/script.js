/* ==================== JavaScript Utilities ==================== */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips, modals, and other interactive elements
    initializeElements();
    initForms();
    initSwiper();
});

/**
 * Initialize all page elements
 */
function initializeElements() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Add confirm dialog for delete buttons
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(btn => {
        if (!btn.getAttribute('onclick')) {
            btn.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this item?')) {
                    e.preventDefault();
                }
            });
        }
    });
}

/**
 * Initialize form validation for HTML5 forms
 */
function initForms() {
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');
            }
        }, false);
    });
}

/**
 * Initialize Swiper slider if available
 */
function initSwiper() {
    if (typeof Swiper === 'undefined') {
        return;
    }

    new Swiper('.mySwiper', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 4500,
            disableOnInteraction: false,
        },
    });
}

/**
 * Validate email address
 */
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

/**
 * Show notification
 */
function showNotification(message, type = 'success') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const mainContent = document.querySelector('main');
    if (mainContent) {
        mainContent.insertBefore(alertDiv, mainContent.firstChild);
    }

    setTimeout(() => {
        alertDiv.style.transition = 'opacity 0.3s ease-out';
        alertDiv.style.opacity = '0';
        setTimeout(() => alertDiv.remove(), 300);
    }, 5000);
}

/**
 * Format date
 */
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
}
