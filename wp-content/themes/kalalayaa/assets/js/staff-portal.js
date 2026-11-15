/**
 * Kalalayaa Staff Portal — Application Logic
 *
 * Vanilla JS single-page application powering the staff portal.
 * Reads campus config from window.kalalayaaStaff (injected by PHP).
 *
 * Screens: Home Feed → Composer → Celebration → Profile
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

(function () {
	'use strict';

	/* ═══════════════════════════════════════════════
	   CONFIG & STATE
	   ═══════════════════════════════════════════════ */

	const cfg = window.kalalayaaStaff || {};

	/** @type {number|null} Campus taxonomy term ID (resolved on init). */
	let campusTermId = null;

	/** @type {File[]} Files queued for upload in the composer. */
	let mediaQueue = [];

	/** @type {boolean} Whether the composer is editing an existing post. */
	let isEditing = false;

	/** @type {number|null} Post ID when editing. */
	let editingPostId = null;

	/** @type {string} Currently active screen ID. */
	let activeScreen = 'sp-screen-home';

	/* ═══════════════════════════════════════════════
	   INIT
	   ═══════════════════════════════════════════════ */

	document.addEventListener('DOMContentLoaded', init);

	async function init() {
		// 1. Set CSS accent properties.
		const root = document.documentElement;
		root.style.setProperty('--sp-accent', cfg.campusAccent || '#0E2E35');
		root.style.setProperty('--sp-accent-bg', cfg.campusAccentBg || 'rgba(14,46,53,0.08)');

		// 2. Populate data-driven text.
		setText('sp-logo', null, cfg.logoUrl, 'src');
		setText('sp-campus-badge', cfg.campusName);
		setText('sp-user-name', cfg.userName);
		setAttr('sp-logout-link', 'href', cfg.logoutUrl || '#');
		setText('sp-greeting-name', cfg.userName);
		setText('sp-greeting-campus', cfg.campusName);
		setText('sp-greeting-text', getGreeting());
		setText('sp-celebration-campus', cfg.campusName);
		setText('sp-profile-name', cfg.userName);
		setText('sp-profile-campus', cfg.campusName);
		setAttr('sp-profile-site', 'href', cfg.homeUrl);
		setAttr('sp-profile-logout', 'href', cfg.logoutUrl || '#');

		// Profile avatar: first letter of name.
		const avatarEl = document.getElementById('sp-profile-avatar');
		if (avatarEl && cfg.userName) {
			avatarEl.textContent = cfg.userName.charAt(0).toUpperCase();
		}

		// 3. Bind events.
		bindNavigation();
		bindComposer();
		bindActions();

		// 4. Resolve campus term ID for REST tagging.
		await resolveCampusTerm();

		// 5. Load posts.
		await fetchPosts();
	}

	/* ═══════════════════════════════════════════════
	   NAVIGATION & ROUTING
	   ═══════════════════════════════════════════════ */

	function showScreen(screenId) {
		// Hide FAB on non-home screens.
		const fab = document.getElementById('sp-fab');
		if (fab) {
			fab.classList.toggle('sp-hidden', screenId !== 'sp-screen-home');
		}

		// Toggle celebration body class.
		document.body.classList.toggle('sp-celebrating', screenId === 'sp-screen-celebration');

		// Switch screens.
		document.querySelectorAll('.sp-screen').forEach(function (el) {
			el.classList.remove('sp-screen--active');
		});
		var target = document.getElementById(screenId);
		if (target) {
			target.classList.add('sp-screen--active');
		}

		// Update bottom nav active state.
		document.querySelectorAll('.sp-bottomnav__item').forEach(function (item) {
			item.classList.toggle(
				'sp-bottomnav__item--active',
				item.getAttribute('data-screen') === screenId
			);
		});

		// Scroll to top.
		window.scrollTo(0, 0);

		activeScreen = screenId;

		// Push history (except celebration — that's transient).
		if (screenId !== 'sp-screen-celebration') {
			var slug = screenId.replace('sp-screen-', '');
			history.pushState({ screen: screenId }, '', '#' + slug);
		}
	}

	function bindNavigation() {
		// Bottom nav tabs.
		document.querySelectorAll('.sp-bottomnav__item').forEach(function (item) {
			item.addEventListener('click', function (e) {
				e.preventDefault();
				showScreen(this.getAttribute('data-screen'));
			});
		});

		// FAB.
		var fab = document.getElementById('sp-fab');
		if (fab) {
			fab.addEventListener('click', function () {
				resetComposer();
				showScreen('sp-screen-composer');
			});
		}

		// Popstate (back button).
		window.addEventListener('popstate', function (e) {
			if (e.state && e.state.screen) {
				showScreen(e.state.screen);
			} else {
				showScreen('sp-screen-home');
			}
		});
	}

	function bindActions() {
		// Delegated click handler for data-action attributes.
		document.addEventListener('click', function (e) {
			var el = e.target.closest('[data-action]');
			if (!el) return;

			var action = el.getAttribute('data-action');
			switch (action) {
				case 'compose':
					resetComposer();
					showScreen('sp-screen-composer');
					break;
				case 'compose-again':
					e.preventDefault();
					resetComposer();
					showScreen('sp-screen-composer');
					break;
				case 'go-home':
					e.preventDefault();
					showScreen('sp-screen-home');
					fetchPosts();
					break;
				case 'publish':
					handlePublish('publish');
					break;
				case 'draft':
					handlePublish('draft');
					break;
			}
		});
	}

	/* ═══════════════════════════════════════════════
	   POSTS FEED
	   ═══════════════════════════════════════════════ */

	async function fetchPosts() {
		var grid = document.getElementById('sp-posts-grid');
		var loading = document.getElementById('sp-loading');
		var empty = document.getElementById('sp-empty-state');

		grid.innerHTML = '';
		loading.classList.remove('sp-hidden');
		empty.classList.add('sp-hidden');

		try {
			var url = cfg.restUrl + 'posts?author=' + cfg.userId
				+ '&per_page=20&_embed&orderby=date&order=desc'
				+ '&status=publish,draft';

			// Add campus filter if we have the term ID.
			if (campusTermId) {
				url += '&campus=' + campusTermId;
			}

			var resp = await apiFetch(url);
			var posts = await resp.json();

			loading.classList.add('sp-hidden');

			if (!posts.length) {
				empty.classList.remove('sp-hidden');
				return;
			}

			posts.forEach(function (post) {
				grid.appendChild(createPostCard(post));
			});

		} catch (err) {
			loading.classList.add('sp-hidden');
			showToast('Couldn\'t load posts. Please refresh.', 'error');
			console.error('fetchPosts:', err);
		}
	}

	function createPostCard(post) {
		var card = document.createElement('div');
		card.className = 'sp-post-card';

		// Thumbnail.
		var imageHtml = '';
		var embedded = post._embedded && post._embedded['wp:featuredmedia'];
		if (embedded && embedded[0] && embedded[0].media_details) {
			var sizes = embedded[0].media_details.sizes;
			var src = (sizes && sizes.medium && sizes.medium.source_url)
				|| embedded[0].source_url || '';
			if (src) {
				imageHtml = '<img class="sp-post-card__image" src="' + escHtml(src) + '" alt="" loading="lazy">';
			}
		}
		if (!imageHtml) {
			imageHtml = '<div class="sp-post-card__image--placeholder">📷</div>';
		}

		var statusClass = post.status === 'publish' ? 'sp-post-card__status--publish' : 'sp-post-card__status--draft';
		var statusLabel = post.status === 'publish' ? 'Published' : 'Draft';

		card.innerHTML = imageHtml
			+ '<div class="sp-post-card__body">'
			+ '<h3 class="sp-post-card__title">' + decodeEntities(post.title.rendered || '(Untitled)') + '</h3>'
			+ '<div class="sp-post-card__meta">'
			+ '<span class="sp-post-card__date">' + formatDate(post.date) + '</span>'
			+ '<span class="sp-post-card__status ' + statusClass + '">' + statusLabel + '</span>'
			+ '</div>'
			+ '<div class="sp-post-card__actions">'
			+ '<button class="sp-post-card__action" data-edit="' + post.id + '">✏️ Edit</button>'
			+ '<button class="sp-post-card__action sp-post-card__action--delete" data-delete="' + post.id + '">🗑 Delete</button>'
			+ '</div>'
			+ '</div>';

		// Edit handler.
		card.querySelector('[data-edit]').addEventListener('click', function () {
			editPost(post.id);
		});

		// Delete handler.
		card.querySelector('[data-delete]').addEventListener('click', function () {
			deletePost(post.id, post.title.rendered);
		});

		return card;
	}

	/* ═══════════════════════════════════════════════
	   COMPOSER — MEDIA UPLOAD
	   ═══════════════════════════════════════════════ */

	function bindComposer() {
		var uploadZone = document.getElementById('sp-upload-zone');
		var fileInput = document.getElementById('sp-file-input');
		var titleInput = document.getElementById('sp-input-title');
		var titleCount = document.getElementById('sp-title-count');

		// Click to upload.
		if (uploadZone) {
			uploadZone.addEventListener('click', function () {
				fileInput.click();
			});
		}

		// File input change.
		if (fileInput) {
			fileInput.addEventListener('change', function () {
				addFilesToQueue(this.files);
				this.value = '';
			});
		}

		// Drag and drop on upload zone.
		if (uploadZone) {
			uploadZone.addEventListener('dragover', function (e) {
				e.preventDefault();
				this.classList.add('sp-upload-zone--active');
			});
			uploadZone.addEventListener('dragleave', function () {
				this.classList.remove('sp-upload-zone--active');
			});
			uploadZone.addEventListener('drop', function (e) {
				e.preventDefault();
				this.classList.remove('sp-upload-zone--active');
				if (e.dataTransfer.files.length) {
					addFilesToQueue(e.dataTransfer.files);
				}
			});
		}

		// Title character count.
		if (titleInput && titleCount) {
			titleInput.addEventListener('input', function () {
				titleCount.textContent = this.value.length;
			});
		}

		// Section drag-to-reorder.
		bindSectionDrag();
	}

	function addFilesToQueue(fileList) {
		for (var i = 0; i < fileList.length && mediaQueue.length < 10; i++) {
			mediaQueue.push(fileList[i]);
		}
		renderThumbnails();
	}

	function renderThumbnails() {
		var container = document.getElementById('sp-media-thumbnails');
		var uploadZone = document.getElementById('sp-upload-zone');
		container.innerHTML = '';

		if (mediaQueue.length === 0) {
			uploadZone.classList.remove('sp-hidden');
			return;
		}

		// Hide upload zone text once files are added (keep clickable).
		// Actually, keep upload zone visible but smaller as an "add more" prompt.

		mediaQueue.forEach(function (file, index) {
			var thumb = document.createElement('div');
			thumb.className = 'sp-thumb';

			if (file.type.startsWith('video/')) {
				var video = document.createElement('video');
				video.src = URL.createObjectURL(file);
				video.muted = true;
				thumb.appendChild(video);
			} else {
				var img = document.createElement('img');
				img.src = URL.createObjectURL(file);
				img.alt = file.name;
				thumb.appendChild(img);
			}

			var removeBtn = document.createElement('button');
			removeBtn.className = 'sp-thumb__remove';
			removeBtn.textContent = '×';
			removeBtn.setAttribute('aria-label', 'Remove');
			removeBtn.addEventListener('click', function () {
				mediaQueue.splice(index, 1);
				renderThumbnails();
			});
			thumb.appendChild(removeBtn);

			container.appendChild(thumb);
		});
	}

	/* ═══════════════════════════════════════════════
	   COMPOSER — SECTION DRAG REORDER
	   ═══════════════════════════════════════════════ */

	function bindSectionDrag() {
		var container = document.getElementById('sp-composer-sections');
		if (!container) return;

		var dragSrc = null;

		container.addEventListener('dragstart', function (e) {
			var section = e.target.closest('.sp-section');
			if (!section) return;
			dragSrc = section;
			section.classList.add('sp-section--dragging');
			e.dataTransfer.effectAllowed = 'move';
			e.dataTransfer.setData('text/plain', ''); // required for Firefox
		});

		container.addEventListener('dragover', function (e) {
			e.preventDefault();
			e.dataTransfer.dropEffect = 'move';
			var section = e.target.closest('.sp-section');
			if (section && section !== dragSrc) {
				section.classList.add('sp-section--dragover');
			}
		});

		container.addEventListener('dragleave', function (e) {
			var section = e.target.closest('.sp-section');
			if (section) {
				section.classList.remove('sp-section--dragover');
			}
		});

		container.addEventListener('drop', function (e) {
			e.preventDefault();
			var dropTarget = e.target.closest('.sp-section');
			if (!dropTarget || !dragSrc || dropTarget === dragSrc) return;

			// Determine position: insert before or after.
			var sections = Array.from(container.querySelectorAll('.sp-section'));
			var dragIdx = sections.indexOf(dragSrc);
			var dropIdx = sections.indexOf(dropTarget);

			if (dragIdx < dropIdx) {
				container.insertBefore(dragSrc, dropTarget.nextSibling);
			} else {
				container.insertBefore(dragSrc, dropTarget);
			}

			dropTarget.classList.remove('sp-section--dragover');
		});

		container.addEventListener('dragend', function () {
			container.querySelectorAll('.sp-section').forEach(function (s) {
				s.classList.remove('sp-section--dragging', 'sp-section--dragover');
			});
			dragSrc = null;
		});
	}

	/* ═══════════════════════════════════════════════
	   COMPOSER — PUBLISH / DRAFT
	   ═══════════════════════════════════════════════ */

	async function handlePublish(status) {
		var title = document.getElementById('sp-input-title').value.trim();
		var description = document.getElementById('sp-input-description').value.trim();
		var commentsOpen = document.getElementById('sp-toggle-comments').checked;
		var publishBtn = document.getElementById('sp-btn-publish');
		var draftBtn = document.getElementById('sp-btn-draft');

		// Validate.
		if (!title) {
			showToast('Please add a title for your moment.', 'error');
			document.getElementById('sp-input-title').focus();
			return;
		}

		// Disable buttons.
		publishBtn.disabled = true;
		draftBtn.disabled = true;
		publishBtn.textContent = status === 'publish' ? '🌟 Sharing…' : '💾 Saving…';

		try {
			// 1. Upload media files.
			var mediaIds = [];
			for (var i = 0; i < mediaQueue.length; i++) {
				var mediaId = await uploadMedia(mediaQueue[i]);
				if (mediaId) mediaIds.push(mediaId);
			}

			// 2. Build content.
			var content = '';
			if (description) {
				content = description.split('\n').map(function (line) {
					return '<p>' + escHtml(line) + '</p>';
				}).join('\n');
			}

			// If multiple images, add gallery block.
			if (mediaIds.length > 1) {
				var galleryIds = mediaIds.join(',');
				content += '\n<!-- wp:gallery {"ids":[' + galleryIds + '],"columns":2} -->';
				content += '\n<figure class="wp-block-gallery columns-2">';
				mediaIds.forEach(function (id) {
					content += '<figure class="wp-block-image"><img data-id="' + id + '" /></figure>';
				});
				content += '</figure>\n<!-- /wp:gallery -->';
			}

			// 3. Create/update post.
			var postData = {
				title: title,
				content: content,
				status: status,
				featured_media: mediaIds.length > 0 ? mediaIds[0] : 0,
				comment_status: commentsOpen ? 'open' : 'closed',
			};

			// Add campus term if available.
			if (campusTermId) {
				postData.campus = [campusTermId];
			}

			var url, method;
			if (isEditing && editingPostId) {
				url = cfg.restUrl + 'posts/' + editingPostId;
				method = 'PUT';
			} else {
				url = cfg.restUrl + 'posts';
				method = 'POST';
			}

			var resp = await apiFetch(url, {
				method: method,
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(postData),
			});

			if (!resp.ok) {
				throw new Error('Failed to save post (HTTP ' + resp.status + ')');
			}

			var savedPost = await resp.json();

			if (status === 'draft') {
				showToast('✅ Draft saved!', 'success');
				publishBtn.disabled = false;
				draftBtn.disabled = false;
				publishBtn.textContent = isEditing ? '🌟 Update Post' : '🌟 Share with Parents';
			} else {
				// Show celebration!
				populateCelebration(savedPost.link, savedPost.title.rendered);
				showScreen('sp-screen-celebration');
			}

		} catch (err) {
			console.error('handlePublish:', err);
			showToast('Something went wrong. Please try again.', 'error');
			publishBtn.disabled = false;
			draftBtn.disabled = false;
			publishBtn.textContent = isEditing ? '🌟 Update Post' : '🌟 Share with Parents';
		}
	}

	async function uploadMedia(file) {
		var formData = new FormData();
		formData.append('file', file, file.name);

		try {
			var resp = await apiFetch(cfg.restUrl + 'media', {
				method: 'POST',
				body: formData,
			});

			if (!resp.ok) {
				console.error('Media upload failed:', resp.status);
				return null;
			}

			var media = await resp.json();
			return media.id;
		} catch (err) {
			console.error('uploadMedia:', err);
			return null;
		}
	}

	/* ═══════════════════════════════════════════════
	   EDIT & DELETE POSTS
	   ═══════════════════════════════════════════════ */

	async function editPost(postId) {
		showToast('Loading post…', 'success');

		try {
			var resp = await apiFetch(cfg.restUrl + 'posts/' + postId + '?_embed');
			if (!resp.ok) throw new Error('HTTP ' + resp.status);
			var post = await resp.json();

			// Populate composer.
			document.getElementById('sp-input-title').value = decodeEntities(post.title.rendered || '');
			document.getElementById('sp-title-count').textContent = (post.title.rendered || '').length;

			// Strip HTML for description.
			var tmp = document.createElement('div');
			tmp.innerHTML = post.content.rendered || '';
			document.getElementById('sp-input-description').value = tmp.textContent || '';

			document.getElementById('sp-toggle-comments').checked = post.comment_status === 'open';

			// Set edit mode.
			isEditing = true;
			editingPostId = postId;
			document.getElementById('sp-composer-heading').textContent = 'Edit Moment';
			document.getElementById('sp-btn-publish').innerHTML = '🌟 Update Post';

			// Clear media queue (editing existing media not supported yet).
			mediaQueue = [];
			renderThumbnails();

			showScreen('sp-screen-composer');
		} catch (err) {
			console.error('editPost:', err);
			showToast('Couldn\'t load post for editing.', 'error');
		}
	}

	async function deletePost(postId, title) {
		var decodedTitle = decodeEntities(title || 'this post');
		if (!confirm('Delete "' + decodedTitle + '"? This cannot be undone.')) {
			return;
		}

		try {
			var resp = await apiFetch(cfg.restUrl + 'posts/' + postId + '?force=true', {
				method: 'DELETE',
			});

			if (!resp.ok) throw new Error('HTTP ' + resp.status);

			showToast('🗑 Post deleted.', 'success');
			fetchPosts();
		} catch (err) {
			console.error('deletePost:', err);
			showToast('Couldn\'t delete post. Please try again.', 'error');
		}
	}

	/* ═══════════════════════════════════════════════
	   CELEBRATION SCREEN
	   ═══════════════════════════════════════════════ */

	function populateCelebration(postUrl, postTitle) {
		var decodedTitle = decodeEntities(postTitle || 'A special moment');

		// Preview link.
		setAttr('sp-link-preview', 'href', postUrl || '#');

		// WhatsApp share.
		var waText = '🌟 ' + decodedTitle + ' — Check out this moment from ' + cfg.campusName + '! ' + postUrl;
		setAttr('sp-btn-whatsapp', 'href', 'https://wa.me/?text=' + encodeURIComponent(waText));
	}

	/* ═══════════════════════════════════════════════
	   CAMPUS TERM RESOLUTION
	   ═══════════════════════════════════════════════ */

	async function resolveCampusTerm() {
		if (!cfg.campusId) return;

		try {
			var resp = await apiFetch(cfg.restUrl + 'campus?slug=' + encodeURIComponent(cfg.campusId));
			if (!resp.ok) return;
			var terms = await resp.json();
			if (terms.length > 0) {
				campusTermId = terms[0].id;
			}
		} catch (err) {
			console.error('resolveCampusTerm:', err);
		}
	}

	/* ═══════════════════════════════════════════════
	   UTILITIES
	   ═══════════════════════════════════════════════ */

	/**
	 * Fetch wrapper that auto-includes the WP nonce header.
	 */
	function apiFetch(url, options) {
		options = options || {};
		options.headers = options.headers || {};
		options.headers['X-WP-Nonce'] = cfg.nonce;
		options.credentials = 'same-origin';
		return fetch(url, options);
	}

	function resetComposer() {
		document.getElementById('sp-input-title').value = '';
		document.getElementById('sp-input-description').value = '';
		document.getElementById('sp-title-count').textContent = '0';
		document.getElementById('sp-toggle-comments').checked = true;
		document.getElementById('sp-composer-heading').textContent = 'Share a Moment';
		document.getElementById('sp-btn-publish').innerHTML = '🌟 Share with Parents';
		document.getElementById('sp-btn-publish').disabled = false;
		document.getElementById('sp-btn-draft').disabled = false;
		document.getElementById('sp-upload-zone').classList.remove('sp-hidden');
		mediaQueue = [];
		renderThumbnails();
		isEditing = false;
		editingPostId = null;
	}

	function getGreeting() {
		var hour = new Date().getHours();
		if (hour < 12) return 'Good morning';
		if (hour < 17) return 'Good afternoon';
		return 'Good evening';
	}

	function formatDate(dateStr) {
		try {
			return new Intl.DateTimeFormat('en-IN', {
				day: 'numeric',
				month: 'short',
				year: 'numeric',
			}).format(new Date(dateStr));
		} catch (e) {
			return dateStr;
		}
	}

	function showToast(message, type) {
		var toast = document.getElementById('sp-toast');
		if (!toast) return;
		toast.textContent = message;
		toast.className = 'sp-toast sp-toast--' + (type || 'success');
		setTimeout(function () {
			toast.classList.add('sp-hidden');
		}, 3000);
	}

	/** Set text content of element by ID. */
	function setText(id, text, attrVal, attrName) {
		var el = document.getElementById(id);
		if (!el) return;
		if (attrName && attrVal !== undefined) {
			el.setAttribute(attrName, attrVal);
		} else if (text !== undefined && text !== null) {
			el.textContent = text;
		}
	}

	/** Set attribute on element by ID. */
	function setAttr(id, attr, val) {
		var el = document.getElementById(id);
		if (el && val !== undefined) el.setAttribute(attr, val);
	}

	/** Escape HTML entities in a string. */
	function escHtml(str) {
		var div = document.createElement('div');
		div.appendChild(document.createTextNode(str));
		return div.innerHTML;
	}

	/** Decode HTML entities (e.g. &amp; → &). */
	function decodeEntities(str) {
		var txt = document.createElement('textarea');
		txt.innerHTML = str;
		return txt.value;
	}

})();
