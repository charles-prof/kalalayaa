/**
 * Kalalayaa Campus Matcher Engine
 * Hick's Law: 2 inputs -> instant, deterministic recommendation
 */

(function () {
  'use strict';

  window.kalalayaaUpdateMatcher = function () {
    var ageSelect = document.getElementById('matcherAge');
    var locSelect = document.getElementById('matcherLocality');
    var resultBox = document.getElementById('matcherResult');
    if (!ageSelect || !locSelect || !resultBox) return;

    var age = ageSelect.value;
    var loc = locSelect.value;
    var config = window.kalalayaaConfig || {};
    var campuses = config.campuses || {};

    var targetCampusId = 'kk-nagar';
    var matchedProgram = 'Foundations & Fine Arts Hub';

    if (age === 'cbse' || loc === 'etechno') {
      targetCampusId = 'e-techno';
      matchedProgram = 'CBSE Grades & Robotics STEM Lab';
    } else if (loc === 'srirangam') {
      targetCampusId = 'srirangam';
      matchedProgram = age === 'toddler' ? 'Toddler Gurukulam Nest' : 'Heritage Pre-KG & Fine Arts';
    } else if (loc === 'crawford') {
      targetCampusId = 'crawford';
      matchedProgram = 'Cozy Neighbourhood Playgroup';
    } else if (loc === 'cantonment') {
      targetCampusId = 'cantonment';
      matchedProgram = 'Pre-KG & Extended Corporate Daycare';
    } else if (loc === 'kailash') {
      targetCampusId = 'kailash-nagar';
      matchedProgram = 'Active Playgroup & Junior Archery';
    } else {
      targetCampusId = 'kk-nagar';
      matchedProgram = age === 'arts' ? 'Fine Arts Academy (Dance & Music)' : 'Foundations & Fine Arts Hub';
    }

    var c = campuses[targetCampusId] || campuses['kk-nagar'] || {
      name: 'Kalalayaa KK Nagar',
      counselor: 'Mrs. Jayanthi Subramanian',
      phone: '+91 94431 82910',
      badge: 'Flagship Hub',
      accent_color: '#0E2E35'
    };

    resultBox.innerHTML =
      '<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">' +
        '<strong style="color:' + c.accent_color + '; font-size:16px;">Recommended: ' + c.name + '</strong>' +
        '<span style="background:rgba(14,46,53,0.08); color:' + c.accent_color + '; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700;">' + (c.badge ? c.badge.split(' ')[0] : 'Campus') + '</span>' +
      '</div>' +
      '<div style="font-size:13.5px; color:#2A4F5A; margin-bottom:12px; line-height:1.5;">' +
        'Best match: <strong>' + matchedProgram + '</strong><br>' +
        'Assigned Counselor: <strong>' + c.counselor + '</strong>' +
      '</div>' +
      '<div style="display:flex; gap:8px; flex-wrap:wrap;">' +
        '<button class="wp-element-button" style="padding:8px 14px; font-size:13px; background:' + c.accent_color + '; color:white; border-radius:6px;" onclick="window.kalalayaaSelectCampus(\'' + targetCampusId + '\')">' +
          'View Campus' +
        '</button>' +
        '<button class="wp-element-button" style="padding:8px 14px; font-size:13px; background:white; color:#0E2E35; border:1px solid #D6E8EB; border-radius:6px;" onclick="window.kalalayaaOpenAdmissionsFor(\'' + targetCampusId + '\')">' +
          'Book Free Visit' +
        '</button>' +
      '</div>';
  };

  document.addEventListener('DOMContentLoaded', function () {
    window.kalalayaaUpdateMatcher();
  });
})();
