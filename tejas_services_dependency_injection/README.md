
# Tejas Services & Dependency Injection Module

This module demonstrates how to create and use a **custom service** in Drupal 11 with **proper dependency injection**.

## Features

-   Registers `EventService` to fetch event data from an external API.
-   Injects the service into `EventController` for structured API calls.
-   Provides a route `/service-events` that directly **renders HTML output** inside the controller.

## Installation

1.  Place the module in:
    
    ```
    modules/custom/tejas_services_dependency_injection/
    
    ```
    
2.  Enable the module using Drush:
    
    ```sh
    drush en tejas_services_dependency_injection -y
    drush cache:rebuild
    
    ```
    
3.  Visit `/service-events` in your browser to see the events.

## Folder Structure

```
tejas_services_dependency_injection/
│── tejas_services_dependency_injection.info.yml
│── tejas_services_dependency_injection.services.yml
│── src/
│   ├── Service/
│   │   ├── EventService.php
│   ├── Controller/
│   │   ├── EventController.php
│── tejas_services_dependency_injection.routing.yml
│── README.md

```

## How It Works

1.  **Service (`EventService`)**
    
    -   Fetches event data from an external API using Guzzle.
    -   Registered in `tejas_services_dependency_injection.services.yml`.
2.  **Controller (`EventController`)**
    
    -   Injects `EventService` via **dependency injection**.
    -   Calls `build()` method to retrieve event data.
    -   **Directly returns HTML output** instead of using templates.
3.  **Route (`/service-events`)**
    
    -   Calls `EventController::build()`, which fetches event data and displays it.

## Example Output

When you visit `/service-events`, you will see:

```
Event Listings

Drupal Meetup
Date: April 10, 2025
A meetup discussing the latest in Drupal.

React Conference
Date: May 5, 2025
A deep dive into React's future.

Open Source Summit
Date: June 15, 2025
A conference on open-source contributions.

```

## Notes

-   Compatible with **Drupal 11**.
-   Uses **Symfony’s dependency injection** for better code separation.
-   No use of Twig or Drupal’s render API—HTML is **generated inside the controller**.

----------

**Now, visit** `/service-events` **and see your service in action!**