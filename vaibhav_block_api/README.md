# Vaibhav Block API

## Introduction
A simple Drupal 11 custom module that provides a Custom block which can be placed anywhere on your Drupal site.

## Requirements
- Drupal 11
- Block module (core)

## Installation
1. Place the module folder in `web/modules/custom/` directory
2. Enable the module via Drush: `drush en vaibhav_block_api` or through the admin UI at `/admin/modules`
3. Clear cache: `drush cr`

## Usage
1. Go to Block layout: `/admin/structure/block`
2. Click "Place block" in the region where you want the block to appear
3. Search for "Namaste Bharat Block"
4. Click "Place block" and configure as needed
5. Save the block placement

## Module Structure
- `vaibhav_block_api.info.yml`: Module definition and dependencies
- `vaibhav_block_api.module`: Hook implementations
- `src/Plugin/Block/NamasteBharat.php`: Block plugin class
