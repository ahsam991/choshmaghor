-- Sample data for ChoshmaZone

-- Insert Categories
INSERT INTO categories (name, slug) VALUES
('Men Sunglasses', 'men-sunglasses'),
('Women Sunglasses', 'women-sunglasses'),
('Unisex', 'unisex'),
('Premium Collection', 'premium-collection'),
('Budget Deals', 'budget-deals');

-- Insert Sample Products
INSERT INTO products (category_id, name, description, price, discount_price, stock_quantity, is_featured, image_url) VALUES
(1, 'Classic Aviator - Men', 'Timeless aviator sunglasses with UV protection. Perfect for casual and formal occasions.', 1500, 1200, 50, 1, '/assets/images/products/aviator-men.jpg'),
(1, 'Wayfarer Style - Men', 'Modern wayfarer design with polarized lens. Great for outdoor activities.', 2000, 1600, 35, 1, '/assets/images/products/wayfarer-men.jpg'),
(2, 'Cat Eye - Women', 'Elegant cat-eye design perfect for fashion-forward women. UV protection included.', 1800, 1400, 40, 1, '/assets/images/products/cateye-women.jpg'),
(2, 'Oversized Fashion - Women', 'Large oversized frames with rose-tinted lenses. Perfect for sunny days.', 2500, 2000, 30, 1, '/assets/images/products/oversized-women.jpg'),
(3, 'Round Retro - Unisex', 'Vintage round style that works for everyone. Classic appeal with modern comfort.', 1300, 1000, 60, 1, '/assets/images/products/round-retro.jpg'),
(4, 'Luxury Navigator - Premium', 'Premium brand sunglasses with superior optics and titanium frame.', 5000, 4200, 25, 1, '/assets/images/products/luxury-navigator.jpg'),
(4, 'Designer Exclusive - Premium', 'Exclusive designer collection with hand-crafted frames and premium materials.', 6000, 5000, 20, 0, '/assets/images/products/designer-exclusive.jpg'),
(5, 'Budget Square - Deals', 'Affordable square frame sunglasses with full UV protection.', 500, 350, 100, 0, '/assets/images/products/budget-square.jpg'),
(5, 'Budget Round - Deals', 'Budget-friendly round frame sunglasses. Perfect starter sunglasses.', 450, 300, 120, 0, '/assets/images/products/budget-round.jpg'),
(1, 'Sport Mirror - Men', 'Sports-focused design with mirror coating and anti-slip frame. Great for active use.', 2200, 1800, 45, 0, '/assets/images/products/sport-mirror.jpg');

-- Insert Sample Admin User
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@choshmazone.com', '$2y$10$V9h5/cIPz0gi.URNNX3FfOK1DdxMi0Vuz7Qwdls6eCNS8jkHz8eme', 'admin');
-- Password: admin123 (hashed with PASSWORD_DEFAULT)

-- Insert Sample Customer User
INSERT INTO users (name, email, password, role) VALUES
('John Doe', 'john@example.com', '$2y$10$V9h5/cIPz0gi.URNNX3FfOK1DdxMi0Vuz7Qwdls6eCNS8jkHz8eme', 'customer'),
('Jane Smith', 'jane@example.com', '$2y$10$V9h5/cIPz0gi.URNNX3FfOK1DdxMi0Vuz7Qwdls6eCNS8jkHz8eme', 'customer');

-- Insert Sample Orders
INSERT INTO orders (user_id, total_amount, status, shipping_address) VALUES
(2, 3200, 'delivered', '{"name":"John Doe","email":"john@example.com","phone":"01711234567","address":"123 Main Street","city":"Dhaka","postal_code":"1205","payment_method":"cod"}'),
(3, 4400, 'pending', '{"name":"Jane Smith","email":"jane@example.com","phone":"01812345678","address":"456 Oak Avenue","city":"Chittagong","postal_code":"4000","payment_method":"cod"}');

-- Insert Sample Order Items
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 1200),
(1, 3, 1, 1400),
(1, 5, 1, 1000),
(2, 2, 2, 1600),
(2, 4, 1, 2000);
