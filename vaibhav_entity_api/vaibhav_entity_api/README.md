# Entity API Module

## Overview
This module provides a "Custom Profile" content entity type for Drupal 10/11. It demonstrates how to implement a fully-featured content entity with all common Drupal entity capabilities.

## Features
- Complete content entity implementation
- It's CRUD operations
- Custom fields
- Related permissions
- Integration with Drupal's admin interface
- Entity form handling

## Entity Structure
The "Custom Profile" entity includes the following fields:
- **Label**: Required, unique string with custom validation
- **Description**: Optional long text, revisionable and translatable
- **Status**: Boolean indicating publishing status
- **Author**: Entity reference to user
- **Created/Changed**: Timestamp fields for tracking entity changes

## Installation
1. Place the module in your Drupal site's `modules/custom` directory.
2. Enable it via Drush or the UI:
   ```sh
   drush en vaibhav_entity_api
   ```

## Usage
### Managing Custom Profiles
1. Navigate to **Content > Custom Profiles** (`/admin/content/custom-profile`).
2. Click **"Add custom profile"** to create a new profile.
3. Fill in the required fields:
   - **Label**: Human-readable name (unique must be int due to custom validator)
   - **Description**: Optional description
   - **Status**: Enable/disable the profile
   - **Author**: Who created the profile

## Permissions
The module defines several permissions to control access to custom profiles:
- **Administer custom profiles**: Full administrative access
- **Add custom profiles**: Create new profiles
- **Edit custom profiles**: Modify existing profiles
- **Delete custom profiles**: Remove profiles
- **View custom profiles**: Access to view profile content

## Field Validation
The module includes custom field validation:
- **UniqueInteger**: Validates that numeric values are integers
- **UniqueField**: Ensures uniqueness of the label field
