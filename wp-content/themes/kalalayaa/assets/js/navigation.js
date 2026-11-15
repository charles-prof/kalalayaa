/**
 * Kalalayaa Navigation Engine
 *
 * Handles campus navigation dropdown, accessible escape listeners,
 * mobile drawer toggle, and sticky header elevation.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    setupDropdowns();
    setupMobileMenu();
    setupSmoothScroll();
    setupStickyHeader();
  });

  function setupDropdowns() {
    var toggles = document.querySelectorAll('.l-nav__toggle');

    toggles.forEach(function (toggle) {
      toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        var menuId = toggle.getAttribute('aria-controls');
        var dropdown = document.getElementById(menuId);
        var isOpen = toggle.getAttribute('aria-expanded') === 'true';

        closeAllDropdowns();

        if (!isOpen && dropdown) {
          dropdown.classList.add('is-open');
          toggle.setAttribute('aria-expanded', 'true');
        }
      });
    });

    // Close when clicking outside
    document.addEventListener('click', function () {
      closeAllDropdowns();
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        closeAllDropdowns();
        closeMobileMenu();
      }
    });
  }

  function closeAllDropdowns() {
    document.querySelectorAll('.l-nav__dropdown.is-open').forEach(function (d) {
      d.classList.remove('is-open');
    });
    document.querySelectorAll('.l-nav__toggle').forEach(function (t) {
      t.setAttribute('aria-expanded', 'false');
    });
  }

  function setupMobileMenu() {
    var hamburger = document.querySelector('.l-nav__hamburger');
    var navList = document.querySelector('.l-nav__list');
    if (!hamburger || !navList) return;

    hamburger.addEventListener('click', function (e) {
      e.stopPropagation();
      var isOpen = hamburger.getAttribute('aria-expanded') === 'true';
      if (isOpen) {
        closeMobileMenu();
      } else {
        navList.classList.add('is-open');
        hamburger.setAttribute('aria-expanded', 'true');
      }
    });
  }

  function closeMobileMenu() {
    var hamburger = document.querySelector('.l-nav__hamburger');
    var navList = document.querySelector('.l-nav__list');
    if (navList) navList.classList.remove('is-open');
    if (hamburger) hamburger.setAttribute('aria-expanded', 'false');
  }

  function setupSmoothScroll() {
    // Smart "Book a Visit" handler: on campus page scrolls directly to campus visit/admissions
    var visitBtns = document.querySelectorAll('.js-book-visit-btn');
    visitBtns.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        var campusSection = document.querySelector('#campus-visit') || document.querySelector('#admissions');
        if (campusSection) {
          e.preventDefault();
          closeAllDropdowns();
          closeMobileMenu();
          campusSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });

    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
      anchor.addEventListener('click', function (e) {
        var targetId = anchor.getAttribute('href');
        if (targetId.length <= 1) return;
        var target = document.querySelector(targetId);
        if (target) {
          e.preventDefault();
          closeAllDropdowns();
          closeMobileMenu();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  }

  function setupStickyHeader() {
    var header = document.querySelector('.l-header');
    if (!header) return;

    window.addEventListener(
      'scroll',
      function () {
        if (window.scrollY > 20) {
          header.classList.add('is-scrolled');
        } else {
          header.classList.remove('is-scrolled');
        }
      },
      { passive: true }
    );
  }
})();
