/**
 * Kalalayaa Navigation & Campus Context Engine
 * Zero build-step human-readable vanilla JavaScript.
 */

(function () {
  'use strict';

  // Toggle Campus Selector Dropdown
  window.kalalayaaToggleCampusMenu = function (e) {
    if (e) e.stopPropagation();
    var selector = document.getElementById('campusSelector');
    var btn = document.getElementById('campusTriggerBtn');
    if (!selector) return;

    var isOpen = selector.classList.toggle('is-open');
    if (btn) btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  };

  // Switch Active Campus Context
  window.kalalayaaSelectCampus = function (campusId) {
    var config = window.kalalayaaConfig || {};
    var campuses = config.campuses || {};

    // Update Strip Buttons
    var buttons = document.querySelectorAll('.strip-btn');
    buttons.forEach(function (btn) {
      var isTarget = btn.getAttribute('data-campus') === campusId;
      btn.classList.toggle('is-active', isTarget);
      btn.setAttribute('aria-selected', isTarget ? 'true' : 'false');
    });

    // Update Header Trigger Label
    var label = document.getElementById('campusTriggerLabel');
    if (label) {
      if (campusId === 'all') {
        label.textContent = 'All Campuses';
      } else if (campuses[campusId]) {
        label.textContent = campuses[campusId].name.replace('Kalalayaa ', '');
      }
    }

    // Close Dropdown
    var selector = document.getElementById('campusSelector');
    if (selector) selector.classList.remove('is-open');

    // Scroll to or filter campus micro-view if present
    var microView = document.getElementById('microView');
    if (microView) {
      if (campusId === 'all') {
        microView.classList.remove('is-active');
      } else {
        microView.classList.add('is-active');
        if (typeof window.kalalayaaRenderMicroView === 'function') {
          window.kalalayaaRenderMicroView(campusId);
        }
      }
    }
  };

  // Click outside to dismiss menus
  document.addEventListener('click', function () {
    var selector = document.getElementById('campusSelector');
    if (selector && selector.classList.contains('is-open')) {
      selector.classList.remove('is-open');
      var btn = document.getElementById('campusTriggerBtn');
      if (btn) btn.setAttribute('aria-expanded', 'false');
    }
  });

  // Modal Helpers
  window.kalalayaaCloseModal = function (modalId) {
    var modal = document.getElementById(modalId);
    if (modal) modal.classList.remove('is-active');
  };
})();
