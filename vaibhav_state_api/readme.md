# Vaibhav State API

## Overview

The Vaibhav State API module provides a demonstration of using the Drupal State API to store and manage persistent state information. This module includes a custom state plugin and a controller to showcase the functionality.

## Features

- Custom state plugin: `CustomState`
- Demo page to interact with the State API

## Installation

1. Download and place the `vaibhav_state_api` module in your Drupal site's `modules/custom` directory.
2. Enable the module using the following Drush command:
   ```sh
   drush en vaibhav_state_api
   ```
   Or enable it through the Drupal admin interface.

## Usage

- Navigate to the demo page provided by the module at `/admin/states`.
- Use the provided links to set a new value or delete the current value stored in the state.

## Customization

### State Plugin
The custom state plugin is defined in `src/Plugin/State/CustomState.php`. This file contains the logic for managing the custom state.

### State Manager
The state manager is defined in `src/State/StateManager.php`. This file contains the logic for handling state-related operations.

### Controller
The controller is defined in `src/Controller/StateDemoController.php`. This file contains the logic for the demo page, including setting and deleting state values.

## Configuration
The module's services are defined in `vaibhav_state_api.services.yml`. This file registers the custom state plugin and state manager service.
