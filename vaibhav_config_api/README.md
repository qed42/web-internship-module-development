# Config API

## Overview
TO add new option in the admin config form `/admin/config`

## Features
- Admin form to set and update footer text.
- Displays the footer text dynamically on the website.

## Installation

### Step 0: Paste in the modules folder
Add this folder in the `/modules/custom` folder of your drupal project.

### Step 1: Enable the Module
Run the following command:
```bash
drush en vaibhav_config_api -y
```
Or enable it through the Drupal UI:
1. Navigate to **Extend** (`/admin/modules`).
2. Find **Vaibhav Config API** and enable it.
3. In your **page.html.twig** file add below line inside footer.
```php
{{ footer_txt }}
```

### Step 2: Configure Footer Text
1. Navigate to **Configuration** → **Vaibhav Config API Settings** (`/admin/config/vaibhav-config-api`).
2. Enter the text you want to display in the footer.
3. Click **Save Configuration**.
