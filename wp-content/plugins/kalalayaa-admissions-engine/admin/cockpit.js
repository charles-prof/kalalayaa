/**
 * Live AJAX Status Changer for Cockpit
 */

jQuery(document).ready(function ($) {
  'use strict';

  $('.kalalayaa-status-toggle').on('change', function () {
    var $select = $(this);
    var postId = $select.data('post-id');
    var newStatus = $select.val();

    $select.prop('disabled', true).css('opacity', 0.6);

    $.post(window.kalalayaaAdmin.ajaxUrl, {
      action: 'kalalayaa_update_lead_status',
      nonce: window.kalalayaaAdmin.nonce,
      post_id: postId,
      status: newStatus
    }, function (response) {
      $select.prop('disabled', false).css('opacity', 1);
      if (response && response.success) {
        $select.css('background-color', '#E6F9E1');
        setTimeout(function () {
          $select.css('background-color', '');
        }, 800);
      } else {
        alert('Failed to update status. Please try again.');
      }
    }).fail(function () {
      $select.prop('disabled', false).css('opacity', 1);
      alert('Network error updating status.');
    });
  });
});
