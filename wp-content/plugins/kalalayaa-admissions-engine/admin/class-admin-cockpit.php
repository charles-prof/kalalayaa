<?php
/**
 * Unified Staff Admin Cockpit
 *
 * Dedicated admin dashboard for Mrs. Dhipikca Rajasekaran and campus coordinators.
 *
 * @package Kalalayaa_Admissions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Kalalayaa_Admin_Cockpit {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_assets' ) );
		add_action( 'wp_ajax_kalalayaa_update_lead_status', array( __CLASS__, 'ajax_update_status' ) );
		add_action( 'admin_init', array( __CLASS__, 'handle_csv_export' ) );
	}

	public static function register_admin_menu() {
		add_menu_page(
			__( 'Admissions Cockpit', 'kalalayaa-admissions' ),
			__( 'Admissions Cockpit', 'kalalayaa-admissions' ),
			'manage_options',
			'kalalayaa-cockpit',
			array( __CLASS__, 'render_cockpit' ),
			'dashicons-welcome-learn-more',
			30
		);

		add_submenu_page(
			'kalalayaa-cockpit',
			__( 'Inquiry CRM', 'kalalayaa-admissions' ),
			__( 'Inquiries List', 'kalalayaa-admissions' ),
			'manage_options',
			'edit.php?post_type=kalalayaa_inquiry'
		);
	}

	public static function enqueue_admin_assets( $hook ) {
		if ( 'toplevel_page_kalalayaa-cockpit' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'kalalayaa-cockpit-css',
			KALALAYAA_ADMISSIONS_URL . 'admin/cockpit.css',
			array(),
			KALALAYAA_ADMISSIONS_VERSION
		);

		wp_enqueue_script(
			'kalalayaa-cockpit-js',
			KALALAYAA_ADMISSIONS_URL . 'admin/cockpit.js',
			array( 'jquery' ),
			KALALAYAA_ADMISSIONS_VERSION,
			true
		);

		wp_localize_script(
			'kalalayaa-cockpit-js',
			'kalalayaaAdmin',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'kalalayaa_cockpit_nonce' ),
			)
		);
	}

	public static function ajax_update_status() {
		check_ajax_referer( 'kalalayaa_cockpit_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Unauthorized' ) );
		}

		$post_id    = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
		$new_status = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : '';

		if ( $post_id && in_array( $new_status, array( 'New', 'Contacted', 'Enrolled' ), true ) ) {
			update_post_meta( $post_id, '_kalalayaa_status', $new_status );
			wp_send_json_success( array( 'status' => $new_status ) );
		}

		wp_send_json_error( array( 'message' => 'Invalid parameters' ) );
	}

	public static function handle_csv_export() {
		if ( ! isset( $_GET['kalalayaa_export_csv'] ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		check_admin_referer( 'kalalayaa_export_action', 'export_nonce' );

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=kalalayaa-admissions-' . gmdate( 'Y-m-d' ) . '.csv' );

		$output = fopen( 'php://output', 'w' );
		fputcsv( $output, array( 'Ref ID', 'Parent Name', 'Phone', 'Email', 'Child Name', 'Child Age', 'Campus', 'Program', 'Counselor', 'Status', 'Date' ) );

		$inquiries = get_posts( array( 'post_type' => 'kalalayaa_inquiry', 'posts_per_page' => -1 ) );
		foreach ( $inquiries as $inq ) {
			fputcsv(
				$output,
				array(
					get_post_meta( $inq->ID, '_kalalayaa_ref_id', true ),
					get_post_meta( $inq->ID, '_kalalayaa_parent_name', true ),
					get_post_meta( $inq->ID, '_kalalayaa_phone', true ),
					get_post_meta( $inq->ID, '_kalalayaa_email', true ),
					get_post_meta( $inq->ID, '_kalalayaa_child_name', true ),
					get_post_meta( $inq->ID, '_kalalayaa_child_age', true ),
					get_post_meta( $inq->ID, '_kalalayaa_campus_name', true ),
					get_post_meta( $inq->ID, '_kalalayaa_program', true ),
					get_post_meta( $inq->ID, '_kalalayaa_counselor', true ),
					get_post_meta( $inq->ID, '_kalalayaa_status', true ) ?: 'New',
					get_the_date( 'Y-m-d H:i', $inq->ID ),
				)
			);
		}

		fclose( $output );
		exit;
	}

	public static function render_cockpit() {
		$all_inquiries = get_posts( array( 'post_type' => 'kalalayaa_inquiry', 'posts_per_page' => -1 ) );
		$total     = count( $all_inquiries );
		$new_count = 0;
		$enrolled  = 0;

		foreach ( $all_inquiries as $i ) {
			$st = get_post_meta( $i->ID, '_kalalayaa_status', true ) ?: 'New';
			if ( 'New' === $st ) $new_count++;
			if ( 'Enrolled' === $st ) $enrolled++;
		}

		$conversion_rate = $total > 0 ? round( ( $enrolled / $total ) * 100 ) : 0;
		$export_url = wp_nonce_url( admin_url( 'admin.php?page=kalalayaa-cockpit&kalalayaa_export_csv=1' ), 'kalalayaa_export_action', 'export_nonce' );
		?>
		<div class="wrap kalalayaa-cockpit-wrap">
			<div class="cockpit-header">
				<div>
					<h1><?php esc_html_e( 'Kalalayaa Staff Admissions Cockpit', 'kalalayaa-admissions' ); ?></h1>
					<p class="subtitle"><?php esc_html_e( 'Unified Multi-Campus Command Center for Mrs. Dhipikca Rajasekaran & Coordinators', 'kalalayaa-admissions' ); ?></p>
				</div>
				<div>
					<a href="<?php echo esc_url( $export_url ); ?>" class="button button-primary">
						📥 <?php esc_html_e( 'Export Inquiries to CSV', 'kalalayaa-admissions' ); ?>
					</a>
				</div>
			</div>

			<!-- KPI Cards -->
			<div class="cockpit-kpi-grid">
				<div class="cockpit-kpi-card">
					<div class="kpi-label"><?php esc_html_e( 'Total Applications', 'kalalayaa-admissions' ); ?></div>
					<div class="kpi-number"><?php echo esc_html( $total ); ?></div>
					<div class="kpi-sub"><?php esc_html_e( 'Across all 6 campuses', 'kalalayaa-admissions' ); ?></div>
				</div>
				<div class="cockpit-kpi-card">
					<div class="kpi-label"><?php esc_html_e( 'Pending Action (New)', 'kalalayaa-admissions' ); ?></div>
					<div class="kpi-number" style="color:#D97706;"><?php echo esc_html( $new_count ); ?></div>
					<div class="kpi-sub"><?php esc_html_e( 'Awaiting counselor callback', 'kalalayaa-admissions' ); ?></div>
				</div>
				<div class="cockpit-kpi-card">
					<div class="kpi-label"><?php esc_html_e( 'Enrollment Rate', 'kalalayaa-admissions' ); ?></div>
					<div class="kpi-number" style="color:#059669;"><?php echo esc_html( $conversion_rate ); ?>%</div>
					<div class="kpi-sub"><?php echo esc_html( $enrolled ); ?> <?php esc_html_e( 'enrolled students', 'kalalayaa-admissions' ); ?></div>
				</div>
				<div class="cockpit-kpi-card">
					<div class="kpi-label"><?php esc_html_e( 'Multi-Campus Sync', 'kalalayaa-admissions' ); ?></div>
					<div class="kpi-number" style="color:#2563EB; font-size:24px; padding-top:6px;">6 Live</div>
					<div class="kpi-sub"><?php esc_html_e( 'Deterministic routing active', 'kalalayaa-admissions' ); ?></div>
				</div>
			</div>

			<!-- Live Table -->
			<div class="cockpit-card">
				<table class="wp-list-table widefat fixed striped">
					<thead>
						<tr>
							<th style="width:140px;"><?php esc_html_e( 'Ref ID', 'kalalayaa-admissions' ); ?></th>
							<th><?php esc_html_e( 'Parent Details', 'kalalayaa-admissions' ); ?></th>
							<th><?php esc_html_e( 'Child Info', 'kalalayaa-admissions' ); ?></th>
							<th><?php esc_html_e( 'Target Campus', 'kalalayaa-admissions' ); ?></th>
							<th><?php esc_html_e( 'Counselor', 'kalalayaa-admissions' ); ?></th>
							<th style="width:130px;"><?php esc_html_e( 'Status', 'kalalayaa-admissions' ); ?></th>
							<th style="width:90px;"><?php esc_html_e( 'Action', 'kalalayaa-admissions' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ( empty( $all_inquiries ) ) : ?>
							<tr>
								<td colspan="7" style="text-align:center; padding:30px; color:#6B7280;">
									<?php esc_html_e( 'No admissions inquiries logged yet. Applications from the website will appear here in real time.', 'kalalayaa-admissions' ); ?>
								</td>
							</tr>
						<?php else : ?>
							<?php foreach ( $all_inquiries as $inq ) :
								$ref     = get_post_meta( $inq->ID, '_kalalayaa_ref_id', true ) ?: ( 'INQ-' . $inq->ID );
								$parent  = get_post_meta( $inq->ID, '_kalalayaa_parent_name', true );
								$phone   = get_post_meta( $inq->ID, '_kalalayaa_phone', true );
								$child   = get_post_meta( $inq->ID, '_kalalayaa_child_name', true );
								$age     = get_post_meta( $inq->ID, '_kalalayaa_child_age', true );
								$campus  = get_post_meta( $inq->ID, '_kalalayaa_campus_name', true );
								$program = get_post_meta( $inq->ID, '_kalalayaa_program', true );
								$couns   = get_post_meta( $inq->ID, '_kalalayaa_counselor', true );
								$status  = get_post_meta( $inq->ID, '_kalalayaa_status', true ) ?: 'New';
								?>
								<tr>
									<td><strong style="font-family:monospace; color:#0E2E35;"><?php echo esc_html( $ref ); ?></strong></td>
									<td>
										<strong><?php echo esc_html( $parent ); ?></strong><br>
										<small><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></small>
									</td>
									<td>
										<strong><?php echo esc_html( $child ); ?></strong><br>
										<small style="color:#6B7280;"><?php echo esc_html( $age ); ?></small>
									</td>
									<td>
										<strong><?php echo esc_html( $campus ); ?></strong><br>
										<small style="color:#6B7280;"><?php echo esc_html( $program ); ?></small>
									</td>
									<td><?php echo esc_html( $couns ); ?></td>
									<td>
										<select class="kalalayaa-status-toggle" data-post-id="<?php echo esc_attr( $inq->ID ); ?>">
											<option value="New" <?php selected( $status, 'New' ); ?>>New Lead</option>
											<option value="Contacted" <?php selected( $status, 'Contacted' ); ?>>Contacted</option>
											<option value="Enrolled" <?php selected( $status, 'Enrolled' ); ?>>Enrolled</option>
										</select>
									</td>
									<td>
										<a href="<?php echo esc_url( get_edit_post_link( $inq->ID ) ); ?>" class="button button-small">
											<?php esc_html_e( 'View', 'kalalayaa-admissions' ); ?>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	}
}
