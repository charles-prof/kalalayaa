/**
 * Kalalayaa Campus Page Engine
 *
 * Provides subtle scroll animations and interactive transitions.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    setupScrollReveal();
  });

  function setupScrollReveal() {
    var targets = document.querySelectorAll(
      '.m-campus-programs__feature, .m-campus-contact__counselor-card, .m-campus-contact__location-card, .m-blog-card, .m-doorway-card, .m-trust__stat'
    );

    if (!targets.length || !('IntersectionObserver' in window)) {
      targets.forEach(function (el) {
        el.classList.add('is-visible');
      });
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );

    targets.forEach(function (el) {
      el.classList.add('is-reveal-target');
      observer.observe(el);
    });
  }
})();
