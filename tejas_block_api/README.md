# Tejas Block API Module

This module provides a custom block named **"Hello World Block"** for Drupal 11.

## Installation
1. Place the module in `modules/custom/tejas_block_api`.
2. Enable it via the command line:
   ```sh
   drush en tejas_block_api -y
   drush cache:rebuild
   ```

## Usage
### 1. Add via Admin UI
- Go to **Structure → Block layout** (`/admin/structure/block`).
- Click **"Place block"** in the desired region.
- Search for **"Hello World Block"** and add it.

### 2. Render in Twig
```twig
{{ drupal_block('tejas_hello_world_block') }}
```

### 3. Render Programmatically
```php
$block = \Drupal::service('plugin.manager.block')->createInstance('tejas_hello_world_block', []);
$render = $block->build();
```

## File Structure
```
tejas_block_api/
│── tejas_block_api.info.yml
│── src/
│   ├── Plugin/
│   │   ├── Block/
│   │   │   ├── HelloWorldBlock.php
│── README.md
```