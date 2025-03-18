# Tejas State API Module

This module leverages Drupal's State API to cache event data and reduce frequent external API calls, optimizing performance for the Events website.

## Installation
1. Place the module in `modules/custom/tejas_state_api`.
2. Enable the module:
   ```sh
   drush en tejas_state_api -y
   drush cache:rebuild
   ```

## Usage
- Visit **`/state-events`** to see events fetched using the State API.
- The API is queried only once every 10 minutes, reducing unnecessary requests.

## Folder Structure
```
tejas_state_api/
│── tejas_state_api.info.yml
│── tejas_state_api.services.yml
│── tejas_state_api.routing.yml
│── src/
│   ├── Controller/
│   │   ├── EventStateController.php
│   ├── Service/
│   │   ├── EventStateService.php
│   ├── Hook/
│   │   ├── ThemeHook.php
│── templates/
│   ├── event-state-card.html.twig
│── README.md
```
