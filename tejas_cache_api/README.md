# Tejas Cache API Module

This module provides a custom route (`/cache-events`) that dynamically fetches event data from an external API and caches the results using Drupal's caching system.

## Installation

1. Place the module in `modules/custom/tejas_cache_api`.
2. Enable the module using Drush:
   ```sh
   drush en tejas_cache_api -y
   drush cache:rebuild
   ```

## Usage

- Visit **`/cache-events`** to see the list of cached events retrieved from an external API.

## Route Information

| Path           | Controller Method            | Permission       |
|---------------|----------------------------|-----------------|
| `/cache-events` | `EventController::build()` | `access content` |

## Folder Structure

```
tejas_cache_api/
│── tejas_cache_api.info.yml
│── tejas_cache_api.routing.yml
│── tejas_cache_api.services.yml
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

When you visit `/cache-events`, you will see:

```
Cached Events

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

### `tejas_cache_api.event_service`
- Fetches event data from an external API (`https://67d7ea5b9d5e3a10152c8af1.mockapi.io/event`).
- Uses `GuzzleHttp\ClientInterface` to make requests.
- Implements caching using `Drupal\Core\Cache\CacheBackendInterface`.

## Caching Mechanism

This module implements caching at two levels:

1. **ID-based Caching**:
   - Stores event data in Drupal's cache system using a cache ID (`tejas_cache_api:events`).
   - Data is retrieved from cache before making an API request.
   - Uses `CACHE_PERMANENT` to store data persistently.

2. **Render Array Caching**:
   - The rendered event list includes cache metadata:
   ```php
   '#cache' => [
      'contexts' => ['url'],
   ],
   ```
   - Ensures that content is cached separately for each URL variation.

## Theming

The `event-card.html.twig` template renders individual event cards:

```twig
<div class="event-card">
  <h2>{{ name }}</h2>
  <p><strong>Date:</strong> {{ datetime }}</p>
  <p>{{ description }}</p>
</div>
```

## Extending the Module

- Modify `EventService.php` to add more caching strategies.
- Update `EventController.php` to handle cache invalidation where necessary.
- Use `'#cache' => ['tags' => ['custom_tag']]` if cache invalidation needs to be tied to configuration changes.

This module demonstrates a structured approach to caching in Drupal, optimizing performance while ensuring dynamic content updates.

