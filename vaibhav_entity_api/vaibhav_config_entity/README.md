# Vaibhav Config Entity Module

## Overview
This module provides a "Config Profile" configuration entity for Drupal 10/11 that allows site administrators to create and manage configuration profiles through the admin UI.

## Features I have added
- Custom Code field with automatic lowercase conversion
- This field gets exported when exporting the config using `drush cex`

## Installation
1. Place the module in your Drupal site's `modules/custom` directory.
2. Enable it via Drush or the UI:
   ```sh
   drush en vaibhav_config_entity
   ```

## Usage
### Managing Config Profiles
1. Navigate to **Structure > Config Profiles** (`/admin/structure/config-profile`).
2. Click **"Add config profile"** to create a new profile.
3. Fill in the required fields:
   - **Label**: Human-readable name
   - **ID**: Machine name (auto-generated)
   - **Description**: Optional description
   - **Code**: Special identifier that is automatically converted to lowercase

### About the Code Field
The **Code** field is a unique feature of this module that:
- Accepts any string input
- Automatically converts all input to lowercase
- Stores the normalized value in the configuration
- Is exportable/importable through Drupal's configuration system

Example usage in code:
```php
$configProfile = \Drupal::entityTypeManager()
  ->getStorage('config_profile')
  ->load('example_profile');
$code = $configProfile->get('code');
```
