(function ($, Drupal) {
  Drupal.behaviors.vaibhavStateApi = {
    attach: function (context, settings) {
      $('.use-ajax', context).once('vaibhavStateApi').on('click', function (e) {
        e.preventDefault();
        var $link = $(this);
        $.ajax({
          url: $link.attr('href'),
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            $('p.value-at-page-load').text('Value at page load: ' + data.current_value);
            $('p.action-performed').text('Action performed: ' + data.after_action);
            $('p.value-after-action').text('Value after action: ' + data.final_value);
          }
        });
      });
    }
  };
})(jQuery, Drupal);
