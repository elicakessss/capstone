import './bootstrap';

// Global auto-refresh handler
window.addEventListener('user-updated', function(e) {
    // You can customize this to update only parts of the UI if needed
    window.location.reload();
});

// Helper to dispatch the event after AJAX success
window.triggerUserUpdated = function() {
    window.dispatchEvent(new Event('user-updated'));
};
