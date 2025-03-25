# Vaibhav Routes & Controllers

## Overview
- A **simple route** that returns a static message.
- A **dynamic route** that accepts a parameter and displays a personalized message.

## Installation

### Step 1: Enable the Module
Run the following command:
```bash
drush en vaibhav_routes_controllers -y
```

## How It Works

### Defined Routes
- `/static` → Displays a static message.
- `/dynamic/{name}` → Accepts a name parameter and displays a personalized message.

### Controller (`VaibhavController`)
- Handles **HTTP GET** requests.
- Returns responses as Drupal **render arrays**.

## Testing the Module
1. **Clear cache:**
   ```bash
   drush cr
   ```
2. **Visit the simple route:**
   ```
   /static
   ```
3. **Visit the dynamic route:**
   ```
   /dynamic/Vaibhav
   ```
