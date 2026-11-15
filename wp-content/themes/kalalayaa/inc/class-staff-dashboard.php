<?php
/**
 * Campus Staff Admin Dashboard
 *
 * Provides a guided, campus-aware WordPress admin experience for
 * Kalalayaa campus editors. Restricts unnecessary menus, injects
 * a welcoming banner, auto-assigns campus taxonomy on post save,
 * and redirects editors straight to their event-posting dashboard.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Kalalayaa_Staff_Dashboard
 *
 * Hooks into WordPress admin to create a guided publishing experience
 * for campus editors. Administrators are never affected.
 */
class Kalalayaa_Staff_Dashboard {

	/**
	 * Campus ID of the currently logged-in editor.
	 *
	 * @var string|null
	 */
	private $campus_id = null;

	/**
	 * Campus data array from the registry.
	 *
	 * @var array|null
	 */
	private $campus_data = null;

	/**
	 * Constructor — registers all hooks.
	 */
	public function __construct() {
		add_action( 'admin_init',      array( $this, 'load_editor_campus' ) );
		add_action( 'admin_menu',      array( $this, 'configure_editor_menu' ), 999 );
		add_action( 'admin_notices',   array( $this, 'render_campus_banner' ) );
		add_action( 'admin_head',      array( $this, 'inject_editor_styles' ) );
		add_action( 'pre_post_update', array( $this, 'auto_assign_campus_term' ), 10, 2 );
		add_action( 'save_post',       array( $this, 'auto_assign_campus_term_on_save' ), 10, 3 );
		add_filter( 'login_redirect',  array( $this, 'redirect_editor_after_login' ), 10, 3 );
	}

	// ──────────────────────────────────────────────────────────────
	// Hook Callbacks
	// ──────────────────────────────────────────────────────────────

	/**
	 * Loads current editor's campus data into class properties.
	 *
	 * Runs on admin_init. Skips administrators.
	 *
	 * @return void
	 */
	public function load_editor_campus() {
		if ( current_user_can( 'administrator' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$user_id   = get_current_user_id();
		$campus_id = get_user_meta( $user_id, '_kalalayaa_campus_id', true );

		// If meta is not set, trigger auto-assignment check
		if ( empty( $campus_id ) && class_exists( 'Kalalayaa_Campus_Taxonomy' ) ) {
			Kalalayaa_Campus_Taxonomy::seed_editor_campus_meta();
			$campus_id = get_user_meta( $user_id, '_kalalayaa_campus_id', true );
		}

		if ( ! empty( $campus_id ) ) {
			$this->campus_id   = sanitize_key( $campus_id );
			$this->campus_data = kalalayaa_get_campus( $this->campus_id );
		}
	}

	/**
	 * Configures the admin menu for editors.
	 *
	 * Removes irrelevant admin pages and adds campus-specific navigation.
	 * Runs on admin_menu at priority 999 (after all menus are registered).
	 *
	 * @return void
	 */
	public function configure_editor_menu() {
		if ( current_user_can( 'administrator' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		// Remove pages editors don't need.
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'options-general.php' );

		// Build the new post URL with campus preset.
		$new_post_url = admin_url( 'post-new.php?post_type=post' );
		if ( $this->campus_id ) {
			$new_post_url = add_query_arg( 'campus_preset', rawurlencode( $this->campus_id ), $new_post_url );
		}

		// Campus name for menu label.
		$campus_name = $this->campus_data ? $this->campus_data['name'] : __( 'My Campus', 'kalalayaa' );

		// Register top-level "My Campus Events" page.
		add_menu_page(
			/* page_title */ sprintf( __( '%s Events', 'kalalayaa' ), $campus_name ),
			/* menu_title */ __( 'My Campus Events', 'kalalayaa' ),
			/* capability */ 'edit_posts',
			/* menu_slug  */ 'kalalayaa-campus-events',
			/* callback   */ array( $this, 'render_campus_events_page' ),
			/* icon       */ 'dashicons-calendar-alt',
			/* position   */ 2
		);

		// Register "Write an Event Post" submenu.
		add_submenu_page(
			/* parent_slug */ 'kalalayaa-campus-events',
			/* page_title  */ __( 'Write an Event Post', 'kalalayaa' ),
			/* menu_title  */ __( 'Write an Event Post', 'kalalayaa' ),
			/* capability  */ 'edit_posts',
			/* menu_slug   */ esc_url( $new_post_url ),
			/* callback    */ null
		);
	}

	/**
	 * Renders the "My Campus Events" dashboard page.
	 *
	 * Shows recent campus posts and a prominent "Write New" CTA.
	 *
	 * @return void
	 */
	public function render_campus_events_page() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( esc_html__( 'You do not have permission to view this page.', 'kalalayaa' ) );
		}

		$campus_name  = $this->campus_data ? esc_html( $this->campus_data['name'] ) : esc_html__( 'Your Campus', 'kalalayaa' );
		$campus_id    = $this->campus_id ? esc_attr( $this->campus_id ) : '';
		$new_post_url = admin_url( 'post-new.php?post_type=post' );
		if ( $campus_id ) {
			$new_post_url = add_query_arg( 'campus_preset', rawurlencode( $campus_id ), $new_post_url );
		}

		// Fetch recent posts for this campus.
		$posts_args = array(
			'post_type'      => 'post',
			'posts_per_page' => 10,
			'post_status'    => array( 'publish', 'draft', 'pending' ),
			'author'         => get_current_user_id(),
		);
		if ( $campus_id ) {
			$posts_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'campus',
					'field'    => 'slug',
					'terms'    => $campus_id,
				),
			);
		}
		$campus_posts = get_posts( $posts_args );

		?>
		<div class="wrap kalalayaa-campus-dashboard">
			<h1 class="wp-heading-inline">
				📸 <?php echo esc_html( sprintf( __( '%s — Event Posts', 'kalalayaa' ), $campus_name ) ); ?>
			</h1>
			<a href="<?php echo esc_url( $new_post_url ); ?>" class="page-title-action">
				<?php esc_html_e( '+ Write an Event Post', 'kalalayaa' ); ?>
			</a>
			<hr class="wp-header-end">

			<?php if ( $this->campus_data ) : ?>
			<div class="kalalayaa-dashboard-info card" style="max-width:640px;margin:20px 0;padding:16px 20px;">
				<p style="margin:0 0 6px;">
					<strong><?php echo esc_html( $this->campus_data['counselor'] ); ?></strong>
					— <?php echo esc_html( $this->campus_data['counselor_title'] ); ?>
				</p>
				<p style="margin:0;color:#555;">
					<?php echo esc_html( $this->campus_data['address'] ); ?>
				</p>
			</div>
			<?php endif; ?>

			<div class="kalalayaa-cta-row" style="margin:24px 0;">
				<a href="<?php echo esc_url( $new_post_url ); ?>"
				   class="button button-primary button-hero">
					✍️ <?php esc_html_e( 'Share a New Campus Moment', 'kalalayaa' ); ?>
				</a>
			</div>

			<h2><?php esc_html_e( 'Recent Event Posts', 'kalalayaa' ); ?></h2>

			<?php if ( empty( $campus_posts ) ) : ?>
				<p><?php esc_html_e( 'No posts yet. Write your first event post to let parents see the magic happening at your campus!', 'kalalayaa' ); ?></p>
			<?php else : ?>
				<table class="wp-list-table widefat fixed striped posts">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Title', 'kalalayaa' ); ?></th>
							<th><?php esc_html_e( 'Status', 'kalalayaa' ); ?></th>
							<th><?php esc_html_e( 'Date', 'kalalayaa' ); ?></th>
							<th><?php esc_html_e( 'Actions', 'kalalayaa' ); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ( $campus_posts as $campus_post ) : ?>
						<tr>
							<td><strong><?php echo esc_html( $campus_post->post_title ? $campus_post->post_title : __( '(no title)', 'kalalayaa' ) ); ?></strong></td>
							<td><?php echo esc_html( ucfirst( $campus_post->post_status ) ); ?></td>
							<td><?php echo esc_html( get_the_date( 'j M Y', $campus_post ) ); ?></td>
							<td>
								<a href="<?php echo esc_url( get_edit_post_link( $campus_post ) ); ?>">
									<?php esc_html_e( 'Edit', 'kalalayaa' ); ?>
								</a>
								<?php if ( 'publish' === $campus_post->post_status ) : ?>
									&nbsp;|&nbsp;
									<a href="<?php echo esc_url( get_permalink( $campus_post ) ); ?>" target="_blank">
										<?php esc_html_e( 'View', 'kalalayaa' ); ?>
									</a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Renders a welcoming campus banner in the admin notice area.
	 *
	 * Shown on every admin page for editor-role users. Skips administrators.
	 *
	 * @return void
	 */
	public function render_campus_banner() {
		if ( current_user_can( 'administrator' ) ) {
			return;
		}

		if ( ! $this->campus_data ) {
			return;
		}

		$campus_name  = esc_html( $this->campus_data['name'] );
		$counselor    = esc_html( $this->campus_data['counselor'] );
		$new_post_url = admin_url( 'post-new.php?post_type=post' );
		if ( $this->campus_id ) {
			$new_post_url = add_query_arg( 'campus_preset', rawurlencode( $this->campus_id ), $new_post_url );
		}

		?>
		<div class="kalalayaa-campus-banner notice" id="kalalayaa-campus-banner">
			<div class="kalalayaa-campus-banner__inner">
				<span class="kalalayaa-campus-banner__icon">🏫</span>
				<div class="kalalayaa-campus-banner__text">
					<strong class="kalalayaa-campus-banner__campus">
						<?php echo $campus_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</strong>
					<span class="kalalayaa-campus-banner__counselor">
						<?php
						printf(
							/* translators: %s: counselor name */
							esc_html__( 'Your counselor: %s', 'kalalayaa' ),
							$counselor // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						);
						?>
					</span>
					<p class="kalalayaa-campus-banner__message">
						<?php
						printf(
							/* translators: %s: campus name */
							esc_html__( 'Welcome back! Share a moment from %s with parents.', 'kalalayaa' ),
							$campus_name // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						);
						?>
					</p>
				</div>
				<a href="<?php echo esc_url( $new_post_url ); ?>"
				   class="button button-primary kalalayaa-campus-banner__cta">
					✍️ <?php esc_html_e( 'Post a Campus Moment', 'kalalayaa' ); ?>
				</a>
			</div>
		</div>
		<?php
	}

	/**
	 * Injects minimal admin CSS for campus editors.
	 *
	 * Note: Inline <style> in admin_head is an accepted pattern for
	 * admin-only dynamic styles (accent colors from registry).
	 * This does NOT affect frontend SMACSS.
	 *
	 * @return void
	 */
	public function inject_editor_styles() {
		if ( current_user_can( 'administrator' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$accent_color = $this->campus_data ? $this->campus_data['accent_color'] : '#0E2E35';
		$accent_bg    = $this->campus_data ? $this->campus_data['accent_bg']    : 'rgba(14,46,53,0.08)';

		// Sanitize colors — accept only valid hex/rgba strings.
		$accent_color = preg_match( '/^#[0-9a-fA-F]{3,8}$/', $accent_color ) ? $accent_color : '#0E2E35';
		$accent_bg    = sanitize_text_field( $accent_bg );

		?>
		<style id="kalalayaa-editor-styles">
		/* Kalalayaa campus editor admin styles */

		/* Hide color scheme selector & unneeded profile rows */
		#color-picker-wrap,
		.user-admin-bar-front-wrap,
		.user-comment-shortcuts-wrap,
		.user-syntax-highlighting-wrap,
		.user-rich-editing-wrap {
			display: none !important;
		}

		/* Campus welcome banner */
		#kalalayaa-campus-banner {
			border-left: 4px solid <?php echo esc_attr( $accent_color ); ?>;
			background: <?php echo esc_attr( $accent_bg ); ?>;
			padding: 0;
			margin-bottom: 20px;
		}

		.kalalayaa-campus-banner__inner {
			display: flex;
			align-items: center;
			gap: 16px;
			padding: 14px 16px;
			flex-wrap: wrap;
		}

		.kalalayaa-campus-banner__icon {
			font-size: 28px;
			line-height: 1;
			flex-shrink: 0;
		}

		.kalalayaa-campus-banner__text {
			flex: 1;
			min-width: 200px;
		}

		.kalalayaa-campus-banner__campus {
			display: block;
			font-size: 15px;
			color: <?php echo esc_attr( $accent_color ); ?>;
		}

		.kalalayaa-campus-banner__counselor {
			display: block;
			font-size: 12px;
			color: #555;
			margin-top: 2px;
		}

		.kalalayaa-campus-banner__message {
			margin: 4px 0 0;
			font-size: 13px;
			color: #444;
		}

		.kalalayaa-campus-banner__cta {
			flex-shrink: 0;
			background: <?php echo esc_attr( $accent_color ); ?> !important;
			border-color: <?php echo esc_attr( $accent_color ); ?> !important;
			color: #fff !important;
		}

		.kalalayaa-campus-banner__cta:hover {
			opacity: 0.88;
		}
		</style>
		<?php
	}

	/**
	 * Auto-assigns campus taxonomy term on pre_post_update.
	 *
	 * Fires before an existing post is updated via wp_update_post().
	 *
	 * @param int   $post_id Post ID.
	 * @param array $data    Post data array.
	 * @return void
	 */
	public function auto_assign_campus_term( $post_id, $data ) {
		if ( current_user_can( 'administrator' ) ) {
			return;
		}

		$campus_id = $this->campus_id;
		if ( empty( $campus_id ) ) {
			$campus_id = get_user_meta( get_current_user_id(), '_kalalayaa_campus_id', true );
		}

		if ( empty( $campus_id ) ) {
			return;
		}

		if ( 'post' !== get_post_type( $post_id ) ) {
			return;
		}

		wp_set_object_terms( $post_id, sanitize_key( $campus_id ), 'campus', true );
	}

	/**
	 * Auto-assigns campus taxonomy term on save_post.
	 *
	 * Fires after a new or updated post is saved. Handles new posts
	 * that pre_post_update does not cover.
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    Post object.
	 * @param bool     $update  Whether this is an update (true) or insert (false).
	 * @return void
	 */
	public function auto_assign_campus_term_on_save( $post_id, $post, $update ) {
		// Skip autosaves, revisions, and auto-drafts.
		if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
			return;
		}

		if ( 'auto-draft' === $post->post_status ) {
			return;
		}

		if ( current_user_can( 'administrator' ) ) {
			return;
		}

		$campus_id = $this->campus_id;
		if ( empty( $campus_id ) && ! empty( $post->post_author ) ) {
			$campus_id = get_user_meta( $post->post_author, '_kalalayaa_campus_id', true );
		}

		if ( empty( $campus_id ) ) {
			return;
		}

		if ( 'post' !== $post->post_type ) {
			return;
		}

		// Use append=false only if no campus term already set; otherwise merge.
		$existing = wp_get_post_terms( $post_id, 'campus', array( 'fields' => 'slugs' ) );
		if ( empty( $existing ) || is_wp_error( $existing ) ) {
			wp_set_object_terms( $post_id, sanitize_key( $campus_id ), 'campus', false );
		}
	}

	/**
	 * Redirects editors to campus events page after login.
	 *
	 * @param string   $redirect_to           The redirect destination URL.
	 * @param string   $requested_redirect_to The requested redirect destination URL.
	 * @param \WP_User $user                  WP_User object (or WP_Error on failure).
	 * @return string
	 */
	public function redirect_editor_after_login( $redirect_to, $requested_redirect_to, $user ) {
		if ( is_wp_error( $user ) || ! ( $user instanceof WP_User ) ) {
			return $redirect_to;
		}

		if ( in_array( 'administrator', (array) $user->roles, true ) ) {
			return $redirect_to;
		}

		if ( in_array( 'editor', (array) $user->roles, true ) ) {
			return admin_url( 'admin.php?page=kalalayaa-campus-events' );
		}

		return $redirect_to;
	}

	// ──────────────────────────────────────────────────────────────
	// Static Utility
	// ──────────────────────────────────────────────────────────────

	/**
	 * Returns campus data for the currently logged-in editor.
	 *
	 * @return array|null Campus data array from the registry, or null.
	 */
	public static function get_editor_campus() {
		if ( current_user_can( 'administrator' ) ) {
			return null;
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			return null;
		}

		$user_id   = get_current_user_id();
		$campus_id = get_user_meta( $user_id, '_kalalayaa_campus_id', true );

		if ( empty( $campus_id ) && class_exists( 'Kalalayaa_Campus_Taxonomy' ) ) {
			Kalalayaa_Campus_Taxonomy::seed_editor_campus_meta();
			$campus_id = get_user_meta( $user_id, '_kalalayaa_campus_id', true );
		}

		if ( empty( $campus_id ) ) {
			return null;
		}

		return kalalayaa_get_campus( sanitize_key( $campus_id ) );
	}
}
