# Tejas Routes & Controllers Module

This module provides a custom route (`/events/more-events`) that fetches events from a mock API and renders them using a Twig template.

## Installation
1. Place the module in `modules/custom/tejas_routes_controllers`.
2. Enable it via the command line:
   ```sh
   drush en tejas_routes_controllers -y
   drush cache:rebuild
   ```

## Usage
- Visit `/events/more-events` to see a list of upcoming events fetched from a mock API.

## Folder Structure
```
tejas_routes_controllers/
│── tejas_routes_controllers.info.yml
│── tejas_routes_controllers.routing.yml
│── src/
│   ├── Controller/
│   │   ├── EventController.php
│── templates/
│   ├── more-events-template.html.twig
│── README.md
```