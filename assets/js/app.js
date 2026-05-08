// ChoshmaZone - Premium JS (Integrated with PHP Backend)

document.addEventListener('DOMContentLoaded', () => {
    
    // ===== THEME TOGGLE =====
    const themeBtn = document.getElementById('theme-toggle');
    const themeIcon = themeBtn ? themeBtn.querySelector('i') : null;
    
    function updateThemeIcon(theme) {
        if (!themeIcon) return;
        if (theme === 'light') {
            themeIcon.className = 'fas fa-sun';
        } else {
            themeIcon.className = 'fas fa-moon';
        }
    }

    // Initialize icon
    updateThemeIcon(document.documentElement.getAttribute('data-theme') || 'dark');

    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            let currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            let newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }

    // ===== HEADER SCROLL =====
    const header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 50);
        });
    }

    // ===== MOBILE NAV =====
    const hamburger = document.querySelector('.hamburger');
    const mobileNav = document.querySelector('.mobile-nav');
    const overlay = document.querySelector('.overlay');
    const mobileClose = document.querySelector('.mobile-nav-close');

    function openNav() {
        mobileNav?.classList.add('open');
        overlay?.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeNav() {
        mobileNav?.classList.remove('open');
        overlay?.classList.remove('show');
        document.body.style.overflow = '';
    }
    hamburger?.addEventListener('click', openNav);
    mobileClose?.addEventListener('click', closeNav);
    overlay?.addEventListener('click', closeNav);

    // ===== CART ACTIONS (AJAX) =====
    const SITE_URL = window.location.origin + '/choshmazone'; // Dynamic URL could be better

    window.addToCart = function(productId, name, price, image) {
        const formData = new FormData();
        const qtyInput = document.getElementById('pd-qty');
        const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
        
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch(`${SITE_URL}/cart/add`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateCartBadge(data.cart_count);
                showToast(`✅ ${name} added to cart!`);
            } else {
                showToast(`❌ ${data.message}`, 'error');
            }
        })
        .catch(err => {
            console.error('Cart Error:', err);
            showToast('❌ Failed to add to cart', 'error');
        });
    };

    window.updateCartQty = function(productId, action) {
        const input = document.querySelector(`.cart-qty-input[data-id="${productId}"]`) || document.getElementById('pd-qty');
        let newQty = parseInt(input.value);
        
        if (action === 'plus') newQty++;
        else if (action === 'minus') newQty--;

        if (newQty < 1) return;

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', newQty);

        fetch(`${SITE_URL}/cart/update`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateCartBadge(data.cart_count);
                if (input) input.value = newQty;
                
                // Update row subtotal if it exists
                const rowTotal = document.getElementById(`item-total-${productId}`);
                if (rowTotal && data.item_subtotal_formatted) {
                    rowTotal.textContent = data.item_subtotal_formatted;
                }
                
                // Update cart totals
                const subtotalEl = document.getElementById('cart-subtotal');
                const grandTotalEl = document.getElementById('cart-grand-total');
                if (subtotalEl && data.totals) subtotalEl.textContent = data.totals.formatted_subtotal;
                if (grandTotalEl && data.totals) grandTotalEl.textContent = data.totals.formatted_total;
                
                showToast(`✅ Cart updated`);
            } else {
                showToast(`❌ ${data.message}`, 'error');
            }
        });
    };

    function updateCartBadge(count) {
        document.querySelectorAll('.cart-badge').forEach(el => {
            el.textContent = count;
            el.style.display = count > 0 ? 'flex' : 'none';
        });
    }

    // Handle cart-specific buttons
    document.querySelectorAll('.cart-qty-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const action = btn.dataset.action;
            updateCartQty(id, action);
        });
    });

    document.querySelectorAll('.remove-cart-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const formData = new FormData();
            formData.append('product_id', id);

            fetch(`${SITE_URL}/cart/remove`, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    updateCartBadge(data.cart_count);
                    showToast(`✅ Item removed`);
                    
                    // Remove row
                    const row = document.getElementById(`cart-row-${id}`);
                    if (row) row.remove();
                    
                    // Update cart totals
                    const subtotalEl = document.getElementById('cart-subtotal');
                    const grandTotalEl = document.getElementById('cart-grand-total');
                    if (subtotalEl && data.totals) subtotalEl.textContent = data.totals.formatted_subtotal;
                    if (grandTotalEl && data.totals) grandTotalEl.textContent = data.totals.formatted_total;
                    
                    // If cart is empty, reload to show empty state
                    if (data.cart_count === 0) {
                        setTimeout(() => location.reload(), 1000);
                    }
                }
            });
        });
    });

    // ===== TOAST NOTIFICATION =====
    window.showToast = function(msg, type = 'success') {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.style.cssText = 'position:fixed;bottom:30px;right:30px;z-index:9999;display:flex;flex-direction:column;gap:10px;';
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement('div');
        toast.className = `toast-item ${type}`;
        toast.style.cssText = `
            background: var(--dark-2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            backdrop-filter: blur(10px);
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        `;
        toast.innerHTML = msg;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.4s forwards';
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    };

    // ===== TABS =====
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(target)?.classList.add('active');
        });
    });

    // ===== ANIMATE ON SCROLL =====
    const observerOptions = { threshold: 0.1 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.product-card, .category-card, .feature-item, .section-header').forEach(el => {
        observer.observe(el);
    });

    // ===== WISHLIST LOGIC =====
    window.toggleWishlist = function(btn, productId, name) {
        let wishlist = JSON.parse(localStorage.getItem('choshmazone_wishlist')) || [];
        
        const index = wishlist.indexOf(productId);
        if (index > -1) {
            wishlist.splice(index, 1);
            btn.classList.remove('active');
            btn.innerHTML = '<i class="far fa-heart"></i>';
            showToast(`Removed ${name} from wishlist`);
        } else {
            wishlist.push(productId);
            btn.classList.add('active');
            btn.innerHTML = '<i class="fas fa-heart"></i>';
            showToast(`Added ${name} to wishlist`);
        }
        
        localStorage.setItem('choshmazone_wishlist', JSON.stringify(wishlist));
        document.cookie = "choshmazone_wishlist=" + JSON.stringify(wishlist) + "; path=/; max-age=" + (60*60*24*365);
        updateWishlistBadge();
    };

    function updateWishlistBadge() {
        let wishlist = JSON.parse(localStorage.getItem('choshmazone_wishlist')) || [];
        document.cookie = "choshmazone_wishlist=" + JSON.stringify(wishlist) + "; path=/; max-age=" + (60*60*24*365);
        document.querySelectorAll('.wishlist-badge').forEach(el => {
            el.textContent = wishlist.length;
            el.style.display = wishlist.length > 0 ? 'flex' : 'none';
        });
    }

    // Initialize wishlist state on page load
    function initWishlist() {
        let wishlist = JSON.parse(localStorage.getItem('choshmazone_wishlist')) || [];
        updateWishlistBadge();
        
        document.querySelectorAll('.wishlist-btn, .wishlist-btn-outline').forEach(btn => {
            const id = btn.dataset.id;
            if (id && wishlist.includes(id)) {
                btn.classList.add('active');
                if (btn.classList.contains('wishlist-btn')) {
                    btn.innerHTML = '<i class="fas fa-heart"></i>';
                }
            }
        });
    }

    initWishlist();

});

// Extra animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    .animate-in {
        animation: fadeInUp 0.8s forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);