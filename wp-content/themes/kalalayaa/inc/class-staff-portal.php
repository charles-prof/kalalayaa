<?php
/**
 * Staff Portal Frontend Controller
 *
 * Powers the standalone staff portal at /staff-portal/. Handles:
 * - Auth gating (redirect non-logged-in visitors to wp-login.php)
 * - Asset isolation (dequeue all theme CSS/JS, enqueue only portal bundle)
 * - Localized config injection (campus accent, REST nonce, user data)
 * - REST API campus auto-tagging on post creation
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Kalalayaa_Staff_Portal
 */
class Kalalayaa_Staff_Portal {

	/**
	 * Constructor — registers all hooks.
	 */
	public function __construct() {
		add_action( 'template_redirect',   array( $this, 'gate_portal_access' ) );
		add_action( 'wp_enqueue_scripts',  array( $this, 'isolate_portal_assets' ), 999 );
		add_action( 'rest_after_insert_post', array( $this, 'rest_auto_assign_campus' ), 10, 2 );
	}

	// ──────────────────────────────────────────────────────────────
	// Auth Gate
	// ──────────────────────────────────────────────────────────────

	/**
	 * Redirects non-logged-in visitors away from the staff portal.
	 *
	 * @return void
	 */
	public function gate_portal_access() {
		if ( ! $this->is_portal_page() ) {
			return;
		}

		if ( ! is_user_logged_in() ) {
			wp_safe_redirect( wp_login_url( home_url( '/staff-portal/' ) ) );
			exit;
		}

		// Only editors (campus staff) and admins may access.
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_safe_redirect( home_url( '/' ) );
			exit;
		}
	}

	// ──────────────────────────────────────────────────────────────
	// Asset Isolation
	// ──────────────────────────────────────────────────────────────

	/**
	 * On the portal page, dequeue all theme assets and enqueue only the portal bundle.
	 *
	 * Runs at priority 999 so all theme/plugin styles are already registered.
	 *
	 * @return void
	 */
	public function isolate_portal_assets() {
		if ( ! $this->is_portal_page() ) {
			return;
		}

		// Hide the WP admin bar on the portal page — we own every pixel.
		add_filter( 'show_admin_bar', '__return_false' );

		// ── Dequeue everything the theme registered ──
		$styles_to_remove = array(
			'kalalayaa-theme',
			'kalalayaa-campus-cover',
			'kalalayaa-campus-gallery',
			'kalalayaa-campus-about',
			'kalalayaa-campus-news',
			'kalalayaa-campus-visit',
			'wp-block-library',
			'classic-theme-styles',
			'global-styles',
			'dashicons',
			'admin-bar',
		);
		foreach ( $styles_to_remove as $handle ) {
			wp_dequeue_style( $handle );
			wp_deregister_style( $handle );
		}

		$scripts_to_remove = array(
			'kalalayaa-navigation',
			'kalalayaa-campus-page',
			'kalalayaa-admissions',
		);
		foreach ( $scripts_to_remove as $handle ) {
			wp_dequeue_script( $handle );
			wp_deregister_script( $handle );
		}

		// ── Enqueue portal-only assets ──
		wp_enqueue_style(
			'kalalayaa-portal-fonts',
			'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap',
			array(),
			null
		);

		wp_enqueue_style(
			'kalalayaa-staff-portal',
			get_theme_file_uri( 'assets/css/staff-portal.css' ),
			array( 'kalalayaa-portal-fonts' ),
			'1.0.0'
		);

		wp_enqueue_script(
			'kalalayaa-staff-portal',
			get_theme_file_uri( 'assets/js/staff-portal.js' ),
			array(),
			'1.0.0',
			true
		);

		// ── Inject portal configuration ──
		$user       = wp_get_current_user();
		$campus_id  = get_user_meta( $user->ID, '_kalalayaa_campus_id', true );
		$campus     = ! empty( $campus_id ) ? kalalayaa_get_campus( $campus_id ) : null;

		$portal_config = array(
			'restUrl'      => esc_url_raw( rest_url( 'wp/v2/' ) ),
			'nonce'        => wp_create_nonce( 'wp_rest' ),
			'userId'       => $user->ID,
			'userName'     => $user->display_name,
			'campusId'     => $campus_id ? $campus_id : '',
			'campusName'   => $campus ? $campus['name'] : __( 'My Campus', 'kalalayaa' ),
			'campusAccent' => $campus ? $campus['accent_color'] : '#0E2E35',
			'campusAccentBg' => $campus ? $campus['accent_bg'] : 'rgba(14,46,53,0.08)',
			'logoUrl'      => get_theme_file_uri( 'assets/images/logo.jpeg' ),
			'homeUrl'      => home_url( '/' ),
			'siteUrl'      => site_url( '/' ),
			'logoutUrl'    => wp_logout_url( home_url( '/' ) ),
		);

		wp_localize_script( 'kalalayaa-staff-portal', 'kalalayaaStaff', $portal_config );
	}

	// ──────────────────────────────────────────────────────────────
	// REST Auto-Tagging
	// ──────────────────────────────────────────────────────────────

	/**
	 * Auto-assigns the campus taxonomy term when a post is created via REST API.
	 *
	 * @param WP_Post         $post    Inserted or updated post object.
	 * @param WP_REST_Request $request Request object.
	 * @return void
	 */
	public function rest_auto_assign_campus( $post, $request ) {
		if ( 'post' !== $post->post_type ) {
			return;
		}

		// Skip administrators — they may tag manually.
		$author = get_userdata( $post->post_author );
		if ( $author && in_array( 'administrator', (array) $author->roles, true ) ) {
			return;
		}

		$campus_id = get_user_meta( $post->post_author, '_kalalayaa_campus_id', true );
		if ( empty( $campus_id ) ) {
			return;
		}

		// Set term only if none already assigned.
		$existing = wp_get_post_terms( $post->ID, 'campus', array( 'fields' => 'slugs' ) );
		if ( empty( $existing ) || is_wp_error( $existing ) ) {
			wp_set_object_terms( $post->ID, sanitize_key( $campus_id ), 'campus', false );
		}
	}

	// ──────────────────────────────────────────────────────────────
	// Helpers
	// ──────────────────────────────────────────────────────────────

	/**
	 * Checks whether the current request is for the staff portal page.
	 *
	 * @return bool
	 */
	private function is_portal_page() {
		return is_page( 'staff-portal' );
	}
}
