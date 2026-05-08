from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import sys

def run_tests():
    print("Starting E2E Tests for ChoshmaZone...")
    options = webdriver.ChromeOptions()
    options.add_argument('--headless')
    options.add_argument('--disable-gpu')
    options.add_argument('--no-sandbox')
    options.add_argument('--window-size=1920,1080')

    try:
        driver = webdriver.Chrome(options=options)
    except Exception as e:
        print(f"Could not initialize Chrome WebDriver: {e}")
        sys.exit(1)

    base_url = "http://localhost/choshmaghor-main/choshmaghor-main"

    try:
        # 1. Test Homepage Load
        print("Testing Homepage Load...")
        driver.get(base_url)
        assert "ChoshmaZone" in driver.title
        print("Homepage loaded successfully.")

        # 2. Test Shop Page & Add to Cart
        print("Testing Add to Cart Flow...")
        driver.get(f"{base_url}/shop")
        
        # Wait for products to load
        wait = WebDriverWait(driver, 10)
        product_cards = wait.until(EC.presence_of_all_elements_located((By.CLASS_NAME, 'product-card')))
        if len(product_cards) > 0:
            add_to_cart_btn = product_cards[0].find_element(By.CLASS_NAME, 'add-to-cart-btn')
            # Extract current cart count
            cart_count_el = driver.find_element(By.CLASS_NAME, 'cart-count')
            initial_count = int(cart_count_el.text) if cart_count_el.text.isdigit() else 0

            # Click add to cart
            driver.execute_script("arguments[0].click();", add_to_cart_btn)
            time.sleep(2) # wait for ajax
            
            # Check cart count increased
            new_count_el = driver.find_element(By.CLASS_NAME, 'cart-count')
            new_count = int(new_count_el.text) if new_count_el.text.isdigit() else 0
            assert new_count > initial_count, "Cart count did not increase"
            print("Add to cart successful.")
        else:
            print("No products found to test add to cart.")

        # 3. Test Wishlist Toggle
        print("Testing Wishlist Toggle...")
        if len(product_cards) > 0:
            wishlist_btn = product_cards[0].find_element(By.CLASS_NAME, 'wishlist-btn')
            
            # Click wishlist
            driver.execute_script("arguments[0].click();", wishlist_btn)
            time.sleep(1) # Wait for localStorage update
            
            # Verify wishlist cookie/localStorage or UI change
            # LocalStorage check
            wishlist_data = driver.execute_script("return window.localStorage.getItem('wishlist');")
            assert wishlist_data is not None and len(wishlist_data) > 2, "Wishlist localStorage is empty"
            print("Wishlist toggle successful.")
            
        print("All Tests Passed Successfully!")
    except Exception as e:
        print(f"Test Failed: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    run_tests()
