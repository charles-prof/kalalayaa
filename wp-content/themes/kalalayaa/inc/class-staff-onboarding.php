<?php
/**
 * Campus Staff Onboarding
 *
 * Provides guided onboarding when a campus editor visits the new post
 * screen. Pre-selects their campus taxonomy term via JavaScript, adds
 * a helpful metabox with writing tips, and sets a friendly title placeholder.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Kalalayaa_Staff_Onboarding
 *
 * Lightweight onboarding layer for campus editors on the post edit screen.
 */
class Kalalayaa_Staff_Onboarding {

	/**
	 * Active campus data for the current screen.
	 *
	 * @var array|null
	 */
	private $active_campus_data = null;

	/**
	 * Constructor — registers all hooks.
	 */
	public function __construct() {
		add_action( 'load-post-new.php', array( $this, 'enqueue_campus_preset_script' ) );
		add_action( 'add_meta_boxes',    array( $this, 'register_writing_tips_metabox' ) );
	}

	// ──────────────────────────────────────────────────────────────
	// Hook Callbacks
	// ──────────────────────────────────────────────────────────────

	/**
	 * Prepares campus-preset asset loading on the new post screen.
	 *
	 * Runs on load-post-new.php. Resolves campus either from query
	 * parameter `campus_preset` or from the editor's saved user meta.
	 *
	 * @return void
	 */
	public function enqueue_campus_preset_script() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$campus_data = null;

		// 1. Check if explicitly provided via query string.
		if ( isset( $_GET['campus_preset'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$campus_data = kalalayaa_get_campus( sanitize_key( $_GET['campus_preset'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		// 2. Fall back to current editor's registered campus.
		if ( ! $campus_data ) {
			$campus_data = Kalalayaa_Staff_Dashboard::get_editor_campus();
		}

		if ( ! $campus_data ) {
			return;
		}

		$this->active_campus_data = $campus_data;
		add_action( 'admin_enqueue_scripts', array( $this, 'do_enqueue_campus_preset_script' ) );
	}

	/**
	 * Actually enqueues the admin-campus-preset.js asset.
	 *
	 * Localises campus data so the JS can read it without hard-coding.
	 *
	 * @return void
	 */
	public function do_enqueue_campus_preset_script() {
		if ( empty( $this->active_campus_data ) ) {
			return;
		}

		$campus_id   = $this->active_campus_data['id'];
		$campus_name = $this->active_campus_data['name'];

		wp_enqueue_script(
			'kalalayaa-admin-campus-preset',
			get_theme_file_uri( 'assets/js/admin-campus-preset.js' ),
			array(), // vanilla JS, no jQuery dependency.
			'1.0.0',
			true
		);

		wp_localize_script(
			'kalalayaa-admin-campus-preset',
			'kalalayaaCampusPreset',
			array(
				'campusId'    => $campus_id,
				'campusName'  => $campus_name,
				/* translators: %s: campus name */
				'placeholder' => sprintf(
					__( 'e.g. Annual Day Celebration at %s!', 'kalalayaa' ),
					$campus_name
				),
			)
		);
	}

	/**
	 * Registers the "Tips for a Great Event Post" metabox.
	 *
	 * Shown to campus editors on the post edit screen.
	 *
	 * @return void
	 */
	public function register_writing_tips_metabox() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		// If admin, show only if campus context is active.
		if ( current_user_can( 'administrator' ) && ! isset( $_GET['campus_preset'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$admin_campus = get_user_meta( get_current_user_id(), '_kalalayaa_campus_id', true );
			if ( empty( $admin_campus ) ) {
				return;
			}
		}

		add_meta_box(
			'kalalayaa_writing_tips',
			__( '📸 Tips for a Great Event Post', 'kalalayaa' ),
			array( $this, 'render_writing_tips_metabox' ),
			'post',
			'side',
			'high'
		);
	}

	/**
	 * Renders the writing tips metabox content.
	 *
	 * @param \WP_Post $post Current post object.
	 * @return void
	 */
	public function render_writing_tips_metabox( $post ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$campus_data = Kalalayaa_Staff_Dashboard::get_editor_campus();

		if ( ! $campus_data && isset( $_GET['campus_preset'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$campus_data = kalalayaa_get_campus( sanitize_key( $_GET['campus_preset'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		$campus_name = $campus_data ? esc_html( $campus_data['name'] ) : esc_html__( 'your campus', 'kalalayaa' );
		?>
		<div class="kalalayaa-writing-tips">
			<p class="kalalayaa-writing-tips__intro" style="font-weight:600;margin:0 0 6px;">
				✍️ <?php
				printf(
					/* translators: %s: campus name */
					esc_html__( 'Sharing a Celebration from %s?', 'kalalayaa' ),
					$campus_name // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
				?>
			</p>
			<p style="font-size:12px;color:#555;margin-bottom:8px;">
				<?php esc_html_e( 'Add photos from the event, describe what made it special, and hit Publish. Parents love to see their children\'s moments!', 'kalalayaa' ); ?>
			</p>
			<ul class="kalalayaa-writing-tips__list" style="font-size:12px;padding-left:16px;margin:0;color:#444;line-height:1.6;">
				<li><?php esc_html_e( '📷 Add at least 2–3 photos so parents can relive the moment.', 'kalalayaa' ); ?></li>
				<li><?php esc_html_e( '🎉 Mention the event name, date, and what the children did.', 'kalalayaa' ); ?></li>
				<li><?php esc_html_e( '💬 Share a quote or feeling — "The children beamed with joy!"', 'kalalayaa' ); ?></li>
				<li><?php esc_html_e( '✅ Click Publish when ready — it goes live on the campus page!', 'kalalayaa' ); ?></li>
			</ul>
		</div>
		<?php
	}
}
