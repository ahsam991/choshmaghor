// Admin Dashboard JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle for Mobile
    const sidebarToggle = document.getElementById('sidebarToggle');
    const adminSidebar = document.getElementById('adminSidebar');
    const overlay = document.createElement('div');
    overlay.className = 'overlay';
    overlay.id = 'adminOverlay';
    
    if (sidebarToggle && adminSidebar) {
        sidebarToggle.addEventListener('click', function() {
            adminSidebar.classList.toggle('open');
            document.body.appendChild(overlay);
            overlay.style.display = 'block';
        });
        
        overlay.addEventListener('click', function() {
            adminSidebar.classList.remove('open');
            overlay.style.display = 'none';
        });
    }
    
    // Delete Product Confirmation
    const deleteButtons = document.querySelectorAll('.btn-delete-product');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            
            if (confirm(`আপনি কি "${productName}" পণ্যটি মুছে ফেলতে চান?`)) {
                deleteProduct(productId);
            }
        });
    });
    
    // Update Order Status
    const statusSelects = document.querySelectorAll('.order-status-select');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.getAttribute('data-order-id');
            const newStatus = this.value;
            updateOrderStatus(orderId, newStatus);
        });
    });
    
    // Form Validation
    const forms = document.querySelectorAll('.admin-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'var(--red)';
                } else {
                    field.style.borderColor = 'var(--border-dim)';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('অনুগ্রহ করে সব আবশ্যকীয় তথ্য পূরণ করুন।');
            }
        });
    });
    
    // Image Preview
    const imageInput = document.getElementById('product-image');
    const imagePreview = document.getElementById('image-preview');
    
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; border-radius: 8px;">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Delete Product Function
function deleteProduct(productId) {
    fetch(`${SITE_URL}/admin/deleteProduct`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('পণ্য সফলভাবে মুছে ফেলা হয়েছে।');
            location.reload();
        } else {
            alert('পণ্য মুছে ফেলতে সমস্যা হয়েছে।');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('একটি সমস্যা হয়েছে।');
    });
}

// Update Order Status Function
function updateOrderStatus(orderId, status) {
    fetch(`${SITE_URL}/admin/updateOrderStatus`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `order_id=${orderId}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('অর্ডার স্ট্যাটাস আপডেট হয়েছে!', 'success');
        } else {
            showNotification('স্ট্যাটাস আপডেট করতে সমস্যা হয়েছে।', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('একটি সমস্যা হয়েছে।', 'error');
    });
}

// Show Notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS Animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    .alert-success {
        background: rgba(76, 175, 80, 0.9);
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
    }
    .alert-error {
        background: rgba(224, 84, 84, 0.9);
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
    }
    .alert-info {
        background: rgba(33, 150, 243, 0.9);
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
    }
`;
document.head.appendChild(style);
