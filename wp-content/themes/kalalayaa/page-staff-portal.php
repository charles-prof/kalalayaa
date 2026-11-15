<?php
/**
 * Template: Staff Portal
 *
 * Standalone single-page application for campus staff to share
 * events, celebrations, and milestones with the parent community.
 * Zero WordPress admin chrome — every pixel is ours.
 *
 * Template Name: Staff Portal
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Auth guard — belt-and-suspenders (also checked in class-staff-portal.php).
if ( ! is_user_logged_in() || ! current_user_can( 'edit_posts' ) ) {
	wp_safe_redirect( wp_login_url( home_url( '/staff-portal/' ) ) );
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<meta name="robots" content="noindex, nofollow">
	<?php wp_head(); ?>
</head>
<body class="sp-body">

<div class="sp-app" id="sp-app">

	<!-- ═══════════════════════════════════════════════
	     TOP BAR
	     ═══════════════════════════════════════════════ -->
	<header class="sp-topbar">
		<img
			class="sp-topbar__logo"
			src=""
			alt="<?php esc_attr_e( 'Kalalayaa', 'kalalayaa' ); ?>"
			id="sp-logo"
		>
		<span class="sp-topbar__campus" id="sp-campus-badge"></span>
		<div class="sp-topbar__spacer"></div>
		<span class="sp-topbar__user" id="sp-user-name"></span>
		<a class="sp-topbar__logout" href="" id="sp-logout-link" title="<?php esc_attr_e( 'Log out', 'kalalayaa' ); ?>">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
		</a>
	</header>

	<!-- ═══════════════════════════════════════════════
	     SCREEN 1 — HOME FEED
	     ═══════════════════════════════════════════════ -->
	<main class="sp-screen sp-screen--active" id="sp-screen-home">
		<div class="sp-screen__inner">

			<!-- Greeting Card -->
			<div class="sp-greeting">
				<h1 class="sp-greeting__title">
					<span id="sp-greeting-text">Good morning</span>, <span id="sp-greeting-name"></span>! 🌸
				</h1>
				<p class="sp-greeting__subtitle">
					<?php esc_html_e( 'Share a moment from', 'kalalayaa' ); ?>
					<strong id="sp-greeting-campus"></strong>
					<?php esc_html_e( 'with parents today.', 'kalalayaa' ); ?>
				</p>
			</div>

			<!-- Loading State -->
			<div class="sp-loading" id="sp-loading">
				<div class="sp-loading__spinner"></div>
				<p class="sp-loading__text"><?php esc_html_e( 'Loading your moments…', 'kalalayaa' ); ?></p>
			</div>

			<!-- Posts Grid -->
			<div class="sp-posts-grid" id="sp-posts-grid"></div>

			<!-- Empty State -->
			<div class="sp-empty-state sp-hidden" id="sp-empty-state">
				<div class="sp-empty-state__icon">📸</div>
				<h2 class="sp-empty-state__title"><?php esc_html_e( 'No moments shared yet', 'kalalayaa' ); ?></h2>
				<p class="sp-empty-state__text">
					<?php esc_html_e( 'Be the first to share a celebration from your campus!', 'kalalayaa' ); ?> 🎉
				</p>
				<button class="sp-btn-primary sp-empty-state__cta" data-action="compose">
					📸 <?php esc_html_e( 'Share Your First Moment', 'kalalayaa' ); ?>
				</button>
			</div>

		</div>
	</main>

	<!-- ═══════════════════════════════════════════════
	     SCREEN 2 — COMPOSER
	     ═══════════════════════════════════════════════ -->
	<section class="sp-screen" id="sp-screen-composer">
		<div class="sp-screen__inner">

			<!-- Composer Header -->
			<div class="sp-composer__header">
				<button class="sp-composer__back" data-action="go-home" aria-label="<?php esc_attr_e( 'Back', 'kalalayaa' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
				</button>
				<h2 class="sp-composer__title" id="sp-composer-heading">
					<?php esc_html_e( 'Share a Moment', 'kalalayaa' ); ?>
				</h2>
			</div>

			<!-- Draggable Sections -->
			<div class="sp-composer-sections" id="sp-composer-sections">

				<!-- Section: Media Upload -->
				<div class="sp-section" draggable="true" data-section="media">
					<div class="sp-section__header">
						<span class="sp-section__handle" aria-hidden="true">⠿</span>
						<span class="sp-section__label"><?php esc_html_e( 'Photos & Video', 'kalalayaa' ); ?></span>
					</div>
					<div class="sp-upload-zone" id="sp-upload-zone">
						<div class="sp-upload-zone__icon">📷</div>
						<p class="sp-upload-zone__text"><?php esc_html_e( 'Tap to add photos or video', 'kalalayaa' ); ?></p>
						<p class="sp-upload-zone__hint"><?php esc_html_e( 'or drag and drop here', 'kalalayaa' ); ?></p>
					</div>
					<input
						type="file"
						id="sp-file-input"
						class="sp-sr-only"
						accept="image/*,video/mp4,video/quicktime"
						multiple
					>
					<div class="sp-media-thumbnails" id="sp-media-thumbnails"></div>
				</div>

				<!-- Section: Title -->
				<div class="sp-section" draggable="true" data-section="title">
					<div class="sp-section__header">
						<span class="sp-section__handle" aria-hidden="true">⠿</span>
						<span class="sp-section__label"><?php esc_html_e( 'Title', 'kalalayaa' ); ?></span>
					</div>
					<input
						type="text"
						class="sp-input"
						id="sp-input-title"
						placeholder="<?php esc_attr_e( 'What happened today?', 'kalalayaa' ); ?>"
						maxlength="200"
						autocomplete="off"
					>
					<div class="sp-char-count"><span id="sp-title-count">0</span>/200</div>
				</div>

				<!-- Section: Description -->
				<div class="sp-section" draggable="true" data-section="description">
					<div class="sp-section__header">
						<span class="sp-section__handle" aria-hidden="true">⠿</span>
						<span class="sp-section__label"><?php esc_html_e( 'Description', 'kalalayaa' ); ?></span>
					</div>
					<textarea
						class="sp-textarea"
						id="sp-input-description"
						placeholder="<?php esc_attr_e( 'Tell parents what made this moment special…', 'kalalayaa' ); ?>"
						rows="4"
					></textarea>
				</div>

			</div>

			<!-- Comments Toggle -->
			<div class="sp-toggle-row">
				<span class="sp-toggle-row__label"><?php esc_html_e( 'Allow parent comments', 'kalalayaa' ); ?></span>
				<label class="sp-toggle">
					<input type="checkbox" id="sp-toggle-comments" checked>
					<span class="sp-toggle__track"></span>
				</label>
			</div>

			<!-- Action Buttons -->
			<div class="sp-composer__actions">
				<button class="sp-btn-primary" id="sp-btn-publish" data-action="publish">
					🌟 <?php esc_html_e( 'Share with Parents', 'kalalayaa' ); ?>
				</button>
				<button class="sp-btn-secondary" id="sp-btn-draft" data-action="draft">
					<?php esc_html_e( 'Save Draft', 'kalalayaa' ); ?>
				</button>
			</div>

		</div>
	</section>

	<!-- ═══════════════════════════════════════════════
	     SCREEN 3 — CELEBRATION 🎉
	     ═══════════════════════════════════════════════ -->
	<section class="sp-screen sp-celebration" id="sp-screen-celebration">
		<div class="sp-celebration__inner">
			<div class="sp-celebration__check" aria-hidden="true">
				<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
			</div>
			<h1 class="sp-celebration__title">✨ <?php esc_html_e( 'Your moment is live!', 'kalalayaa' ); ?></h1>
			<p class="sp-celebration__subtitle">
				<?php esc_html_e( 'Parents at', 'kalalayaa' ); ?>
				<strong id="sp-celebration-campus"></strong>
				<?php esc_html_e( 'can see it now.', 'kalalayaa' ); ?>
			</p>

			<div class="sp-celebration__actions">
				<a class="sp-btn-whatsapp" id="sp-btn-whatsapp" href="#" target="_blank" rel="noopener">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.612.637l4.669-1.418A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.143 0-4.144-.663-5.787-1.8l-.404-.27-2.762.84.776-2.84-.285-.424A9.96 9.96 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
					<?php esc_html_e( 'Share on WhatsApp', 'kalalayaa' ); ?>
				</a>
				<a class="sp-btn-outline" id="sp-link-preview" href="#" target="_blank" rel="noopener">
					👁 <?php esc_html_e( 'See how it looks', 'kalalayaa' ); ?>
				</a>
			</div>

			<div class="sp-celebration__links">
				<a class="sp-celebration__link" href="#" data-action="compose-again">
					<?php esc_html_e( 'Share Another Moment →', 'kalalayaa' ); ?>
				</a>
				<a class="sp-celebration__link" href="#" data-action="go-home">
					<?php esc_html_e( '← Back to My Campus', 'kalalayaa' ); ?>
				</a>
			</div>
		</div>
	</section>

	<!-- ═══════════════════════════════════════════════
	     SCREEN 4 — PROFILE
	     ═══════════════════════════════════════════════ -->
	<section class="sp-screen" id="sp-screen-profile">
		<div class="sp-screen__inner">
			<div class="sp-profile">
				<div class="sp-profile__avatar" id="sp-profile-avatar"></div>
				<h2 class="sp-profile__name" id="sp-profile-name"></h2>
				<span class="sp-profile__campus" id="sp-profile-campus"></span>
				<span class="sp-profile__role"><?php esc_html_e( 'Campus Editor', 'kalalayaa' ); ?></span>

				<div class="sp-profile__actions">
					<a class="sp-profile__link" href="" id="sp-profile-site" target="_blank" rel="noopener">
						🌐 <?php esc_html_e( 'Visit Public Website', 'kalalayaa' ); ?>
					</a>
					<a class="sp-profile__link sp-profile__link--danger" href="" id="sp-profile-logout">
						<?php esc_html_e( 'Log Out', 'kalalayaa' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══════════════════════════════════════════════
	     FLOATING ACTION BUTTON
	     ═══════════════════════════════════════════════ -->
	<button class="sp-fab" id="sp-fab" data-action="compose" aria-label="<?php esc_attr_e( 'Share a Moment', 'kalalayaa' ); ?>">
		📸
	</button>

	<!-- ═══════════════════════════════════════════════
	     BOTTOM NAVIGATION
	     ═══════════════════════════════════════════════ -->
	<nav class="sp-bottomnav" id="sp-bottomnav">
		<a class="sp-bottomnav__item sp-bottomnav__item--active" href="#" data-screen="sp-screen-home">
			<span class="sp-bottomnav__icon">🏠</span>
			<span class="sp-bottomnav__label"><?php esc_html_e( 'Home', 'kalalayaa' ); ?></span>
		</a>
		<a class="sp-bottomnav__item" href="#" data-screen="sp-screen-composer">
			<span class="sp-bottomnav__icon">📸</span>
			<span class="sp-bottomnav__label"><?php esc_html_e( 'Share', 'kalalayaa' ); ?></span>
		</a>
		<a class="sp-bottomnav__item" href="#" data-screen="sp-screen-profile">
			<span class="sp-bottomnav__icon">👤</span>
			<span class="sp-bottomnav__label"><?php esc_html_e( 'Profile', 'kalalayaa' ); ?></span>
		</a>
	</nav>

	<!-- Toast Notification -->
	<div class="sp-toast sp-hidden" id="sp-toast" role="alert" aria-live="polite"></div>

</div><!-- .sp-app -->

<?php wp_footer(); ?>
</body>
</html>
