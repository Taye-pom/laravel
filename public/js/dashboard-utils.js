// Dashboard utilities
window.DashboardUtils = {
    // Safe element getter
    getElement: function(id) {
        const element = document.getElementById(id);
        if (!element) {
            console.warn(`Element with id "${id}" not found`);
        }
        return element;
    },
    
    // Safe event listener
    addEventListener: function(id, event, handler) {
        const element = this.getElement(id);
        if (element) {
            element.addEventListener(event, handler);
        }
    },
    
    // Safe query selector
    querySelector: function(selector) {
        const element = document.querySelector(selector);
        if (!element) {
            console.warn(`Element with selector "${selector}" not found`);
        }
        return element;
    },
    
    // Show section safely
    showSection: function(sectionName) {
        // Hide all sections
        document.querySelectorAll(".content-section").forEach(section => {
            section.classList.remove("active");
        });
        
        // Show selected section
        const targetSection = this.getElement(sectionName);
        if (targetSection) {
            targetSection.classList.add("active");
        }
        
        // Update navbar active state
        document.querySelectorAll(".nav-link").forEach(link => {
            link.classList.remove("active");
        });
        
        const activeLink = document.querySelector(`[onclick*="showSection('${sectionName}')"]`);
        if (activeLink) {
            activeLink.classList.add("active");
        }
        
        // Scroll to top of the page to show the content
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    
    // Initialize charts safely
    initCharts: function() {
        // Chart.js initialization code here
        console.log("Charts initialized safely");
    },
    
    // Safe modal operations
    showModal: function(modalId) {
        const modal = this.querySelector(`#${modalId}`);
        if (modal && typeof bootstrap !== 'undefined') {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    },
    
    hideModal: function(modalId) {
        const modal = this.querySelector(`#${modalId}`);
        if (modal && typeof bootstrap !== 'undefined') {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) {
                bsModal.hide();
            }
        }
    }
};

// Global showSection function
window.showSection = function(sectionName) {
    DashboardUtils.showSection(sectionName);
};

// Safe initialization
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard utilities loaded successfully');
    
    // Initialize any global functionality here
    if (typeof Chart !== 'undefined') {
        DashboardUtils.initCharts();
    }
});