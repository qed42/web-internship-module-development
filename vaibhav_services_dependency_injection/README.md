# Services & Dependency Injection

## Installation

### Step 1: Enable the Module
Run the following command:
```bash
drush en vaibhav_services_dependency_injection -y
```

### Custom Service (CustomService)

- Defined in src/Service/CustomService.php.
- Provides a technology-related message.

### Controller (`ServiceDemoController`)
- Uses **dependency injection** to access the service.
- Displays the message on the route `/vaibhav-service-demo`.

## API Route
- **Path:** `/vaibhav-service-demo`
- **Method:** `GET`
- **Displays:** A technology-related fact.


## Testing the Module
1. **Clear cache:**
   ```bash
   drush cr
   ```
2. **Visit the route:**
   ```
   /vaibhav-service-demo
   ```
3. **Expected Output:**
   - A page with the title **Technology Fact**.
   - A message which will contain below:
     > "Did you know? Drupal is a powerful CMS that enables developers to build dynamic and flexible websites. It is open-source, written in PHP, and follows a modular architecture!"
