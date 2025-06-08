from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import traceback

driver = webdriver.Chrome()

try:
    driver.get("http://localhost/miniproject/student_login.php")
    wait = WebDriverWait(driver, 10)

    # Wait for inputs on login page
    reg_no_input = wait.until(EC.presence_of_element_located((By.NAME, "reg_no")))
    dob_input = wait.until(EC.presence_of_element_located((By.NAME, "dob")))

    reg_no_input.send_keys("12345")
    dob_input.send_keys("2000-01-01")

    submit_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//button[@type='submit']")))
    submit_button.click()

    # After submit, wait for something specific on dashboard page.
    # Example: wait for URL to contain 'student_dashboard.php'
    wait.until(EC.url_contains("student_dashboard.php"))

    # Alternatively, wait for some unique element on dashboard:
    # dashboard_element = wait.until(EC.presence_of_element_located((By.ID, "unique-dashboard-element-id")))

    print("✅ Login test passed!")

except Exception as e:
    print("❌ Test failed:")
    print(f"Exception type: {type(e).__name__}")
    print(f"Exception message: {e}")
    print("Traceback:")
    traceback.print_exc()

finally:
    driver.quit()
