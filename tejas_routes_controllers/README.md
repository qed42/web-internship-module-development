
# Tejas Routes & Controllers Module

This module provides a custom route (`/more-events`) that returns a hardcoded HTML response with a list of upcoming events.

## Installation

1. Place the module in `modules/custom/tejas_routes_controllers`.
2. Enable the module using Drush:
   ```sh
   drush en tejas_routes_controllers -y
   drush cache:rebuild
   ```

## Usage

- Visit **`/more-events`** to see the hardcoded list of events.

## Route Information

| Path                 | Controller Method                          | Permission       |
|----------------------|------------------------------------------|-----------------|
| `/events/more-events` | `EventController::build()` | `access content` |

## Folder Structure

```
tejas_routes_controllers/
│── tejas_routes_controllers.info.yml
│── tejas_routes_controllers.routing.yml
│── src/
│   ├── Controller/
│   │   ├── EventController.php
│── README.md
```

## Example Output

When you visit `/more-events`, you will see:

```
Upcoming Events

Drupal Meetup
Date: April 10, 2025
Join us for an exciting discussion on the latest Drupal features.

React Conference
Date: May 5, 2025
Explore the future of React.js with industry experts.

Open Source Summit
Date: June 15, 2025
A deep dive into open-source contributions and collaborations.
```