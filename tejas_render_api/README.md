# Tejas Render API Module

This module provides a custom route (`/render-events`) that dynamically fetches event data from an external API and renders event cards using a structured theme system.

## Installation

1. Place the module in `modules/custom/tejas_render_api`.
2. Enable the module using Drush:
   ```sh
   drush en tejas_render_api -y
   drush cache:rebuild
   ```

## Usage

- Visit **`/render-events`** to see the list of events dynamically retrieved from an external API.

## Route Information

| Path             | Controller Method            | Permission       |
|-----------------|----------------------------|-----------------|
| `/render-events` | `EventController::build()` | `access content` |

## Folder Structure

```
tejas_render_api/
│── tejas_render_api.info.yml
│── tejas_render_api.routing.yml
│── tejas_render_api.services.yml
│── src/
│   ├── Controller/
│   │   ├── EventController.php
│   ├── Service/
│   │   ├── EventService.php
│   ├── Hook/
│   │   ├── ThemeHook.php
│── templates/
│   ├── event-card.html.twig
│── README.md
```

## Example Output

When you visit `/render-events`, you will see:

```
Rendered Events

Event Name: Drupal Meetup
Date: April 10, 2025
Description: Join us for an exciting discussion on the latest Drupal features.

Event Name: React Conference
Date: May 5, 2025
Description: Explore the future of React.js with industry experts.

Event Name: Open Source Summit
Date: June 15, 2025
Description: A deep dive into open-source contributions and collaborations.
```

## Services

### `tejas_render_api.event_service`
- Fetches event data from an external API (`https://67d7ea5b9d5e3a10152c8af1.mockapi.io/event`).
- Uses `GuzzleHttp\ClientInterface` to make requests.

### `tejas_render_api.theme_hook`
- Defines a theme hook (`event_card`) for rendering events using Twig templates.

## Theming

The `event-card.html.twig` template renders individual event cards:

```twig
<div class="event-card">
  <h2>{{ name }}</h2>
  <p><strong>Date:</strong> {{ datetime }}</p>
  <p>{{ description }}</p>
</div>
```

