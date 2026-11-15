/**
 * Admin Campus Preset Helper
 *
 * Pre-selects campus taxonomy and sets helper placeholder on New Post screen.
 * Runs only when campus_preset query param is present.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

(function () {
	'use strict';

	function initCampusPreset() {
		var params = new URLSearchParams(window.location.search);
		var campusPreset = params.get('campus_preset');

		// Check if query param or localized script data provided the preset.
		if (!campusPreset && window.kalalayaaCampusPreset && window.kalalayaaCampusPreset.campusId) {
			campusPreset = window.kalalayaaCampusPreset.campusId;
		}

		if (!campusPreset) {
			return;
		}

		var campusName = (window.kalalayaaCampusPreset && window.kalalayaaCampusPreset.campusName)
			? window.kalalayaaCampusPreset.campusName
			: campusPreset;

		var placeholder = (window.kalalayaaCampusPreset && window.kalalayaaCampusPreset.placeholder)
			? window.kalalayaaCampusPreset.placeholder
			: 'e.g. Annual Day Celebration at ' + campusName + '!';

		// 1. Update Document Title prefix
		if (document.title && !document.title.startsWith('[' + campusName + ']')) {
			document.title = '[' + campusName + '] ' + document.title;
		}

		// 2. Set Post Title placeholder (Classic & Gutenberg)
		function applyTitlePlaceholder() {
			// Classic editor
			var classicTitle = document.getElementById('title');
			if (classicTitle && !classicTitle.value) {
				classicTitle.setAttribute('placeholder', placeholder);
			}

			// Gutenberg / Block Editor title element
			var blockTitles = document.querySelectorAll(
				'.editor-post-title__input, .editor-post-title textarea, [data-rich-text-placeholder]'
			);
			blockTitles.forEach(function (el) {
				el.setAttribute('placeholder', placeholder);
				if (el.getAttribute('data-placeholder')) {
					el.setAttribute('data-placeholder', placeholder);
				}
			});
		}

		// 3. Pre-select Campus Taxonomy Term (Classic & Gutenberg DOM)
		function applyTaxonomySelection() {
			// Search for checkboxes or radios with matching value, id, or label text
			var inputs = document.querySelectorAll(
				'#campuschecklist input[type="checkbox"], #campuschecklist input[type="radio"], ' +
				'.editor-post-taxonomies__hierarchical-terms-list input[type="checkbox"], ' +
				'.components-panel__body input[type="checkbox"]'
			);

			inputs.forEach(function (input) {
				var label = input.closest('label');
				var labelText = label ? label.textContent.trim().toLowerCase() : '';
				var val = (input.value || '').toLowerCase();
				var targetSlug = campusPreset.toLowerCase();

				if (
					val === targetSlug ||
					labelText.indexOf(targetSlug) !== -1 ||
					labelText.indexOf(campusName.toLowerCase()) !== -1
				) {
					if (!input.checked) {
						input.checked = true;
						input.dispatchEvent(new Event('change', { bubbles: true }));
					}
				}
			});

			// If Gutenberg wp.data store is ready
			if (window.wp && wp.data && wp.data.select && wp.data.dispatch) {
				try {
					var taxonomy = wp.data.select('core').getTaxonomy('campus');
					if (taxonomy) {
						var terms = wp.data.select('core').getEntityRecords('taxonomy', 'campus', { slug: campusPreset, per_page: 1 });
						if (terms && terms.length > 0) {
							var currentTerms = wp.data.select('core/editor').getEditedPostAttribute('campus') || [];
							if (currentTerms.indexOf(terms[0].id) === -1) {
								var newTerms = currentTerms.concat([terms[0].id]);
								wp.data.dispatch('core/editor').editPost({ campus: newTerms });
							}
						}
					}
				} catch (e) {
					// Fallback to DOM manipulation
				}
			}
		}

		applyTitlePlaceholder();
		applyTaxonomySelection();

		// Retry periodically for asynchronous block editor mounting
		var attempts = 0;
		var interval = setInterval(function () {
			attempts++;
			applyTitlePlaceholder();
			applyTaxonomySelection();
			if (attempts > 15) {
				clearInterval(interval);
			}
		}, 500);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initCampusPreset);
	} else {
		initCampusPreset();
	}
})();
