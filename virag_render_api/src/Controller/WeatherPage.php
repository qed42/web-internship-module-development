<?php 

declare(strict_types=1);

namespace Drupal\anytown\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for anytown.weather_page route.
 */
class WeatherPage extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build(): array {
    // JavaScript for handling user input and updating the weather widget
    $widget_script = '<script>
        (function(d, s, id) {
            if (d.getElementById(id)) return;
            const fjs = d.getElementsByTagName(s)[0];
            const js = d.createElement(s);
            js.id = id;
            js.src = "https://www.tomorrow.io/v1/widget/sdk/sdk.bundle.min.js";
            fjs.parentNode.insertBefore(js, fjs);
        })(document, "script", "tomorrow-sdk");

        function updateWeatherWidget(location) {
            const widget = document.getElementById("tomorrow-widget");
            widget.setAttribute("data-location-id", location);
            if (window.__TOMORROW__) {
                window.__TOMORROW__.renderWidget();
            }
        }

        function fetchUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        updateWeatherWidget(lat + "," + lon);
                    },
                    function() {
                        updateWeatherWidget("New York"); // Default fallback location
                    }
                );
            } else {
                updateWeatherWidget("New York");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetchUserLocation();
            const inputField = document.getElementById("location-input");
            inputField.addEventListener("change", function() {
                updateWeatherWidget(this.value.trim());
            });
        });
    </script>';

    // Input field for user to enter a city
    $location_input = '<input type="text" id="location-input" placeholder="Enter city name" style="margin-bottom: 10px; display: block;">';

    // Tomorrow.io Weather Widget
    $widget_container = '<div id="tomorrow-widget" class="tomorrow"
       data-language="EN"
       data-unit-system="METRIC"
       data-skin="dark"
       data-widget-type="aqiPollen"
       style="padding-bottom:22px;position:relative;">
       <a href="https://www.tomorrow.io/weather-api/"
          rel="nofollow noopener noreferrer"
          target="_blank"
          style="position: absolute; bottom: 0; transform: translateX(-50%); left: 50%;">
          <img alt="Powered by the Tomorrow.io Weather API"
               src="https://weather-website-client.tomorrow.io/img/powered-by.svg"
               width="250" height="18"/>
       </a>
    </div>';

    $output = "<p>Check out this weekend's weather forecast and come prepared. The market is mostly outside and takes place rain or shine.</p>";
    $output .= $location_input . $widget_script . $widget_container;
    $output .= '<h3>Weather related closures</h3><ul><li>Ice rink closed until winter - please stay off while we prepare it.</li><li>Parking behind Apple Lane is still closed from all the rain last week.</li></ul>';

    return [
      '#markup' => $output,
      '#allowed_tags' => ['script', 'div', 'p', 'h3', 'ul', 'li', 'a', 'img', 'input'], // Allow script & input tags.
    ];
  }
}
