<?php
/**
 * Custom Post Type: kalalayaa_inquiry
 *
 * Dedicated data container for admissions applications.
 *
 * @package Kalalayaa_Admissions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Kalalayaa_Inquiry_CPT {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_cpt' ) );
		add_filter( 'manage_kalalayaa_inquiry_posts_columns', array( __CLASS__, 'custom_columns' ) );
		add_action( 'manage_kalalayaa_inquiry_posts_custom_column', array( __CLASS__, 'render_columns' ), 10, 2 );
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_kalalayaa_inquiry', array( __CLASS__, 'save_meta' ) );
	}

	public static function register_cpt() {
		$labels = array(
			'name'               => _x( 'Inquiries', 'post type general name', 'kalalayaa-admissions' ),
			'singular_name'      => _x( 'Inquiry', 'post type singular name', 'kalalayaa-admissions' ),
			'menu_name'          => _x( 'Admissions CRM', 'admin menu', 'kalalayaa-admissions' ),
			'all_items'          => __( 'All Inquiries', 'kalalayaa-admissions' ),
			'view_item'          => __( 'View Inquiry', 'kalalayaa-admissions' ),
			'search_items'       => __( 'Search Inquiries', 'kalalayaa-admissions' ),
			'not_found'          => __( 'No inquiries found', 'kalalayaa-admissions' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => false, // Shown inside the master Admissions Cockpit menu
			'query_var'           => false,
			'rewrite'             => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'supports'            => array( 'title' ),
		);

		register_post_type( 'kalalayaa_inquiry', $args );
	}

	public static function custom_columns( $columns ) {
		return array(
			'cb'         => '<input type="checkbox" />',
			'title'      => __( 'Reference ID & Parent', 'kalalayaa-admissions' ),
			'child'      => __( 'Child Details', 'kalalayaa-admissions' ),
			'campus'     => __( 'Campus & Program', 'kalalayaa-admissions' ),
			'counselor'  => __( 'Assigned Counselor', 'kalalayaa-admissions' ),
			'status'     => __( 'Status', 'kalalayaa-admissions' ),
			'date'       => __( 'Received Date', 'kalalayaa-admissions' ),
		);
	}

	public static function render_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'child':
				$name = get_post_meta( $post_id, '_kalalayaa_child_name', true );
				$age  = get_post_meta( $post_id, '_kalalayaa_child_age', true );
				echo esc_html( $name ) . ' <span style="color:#6B7280;">(' . esc_html( $age ) . ')</span>';
				break;

			case 'campus':
				$campus = get_post_meta( $post_id, '_kalalayaa_campus_name', true );
				$prog   = get_post_meta( $post_id, '_kalalayaa_program', true );
				echo '<strong>' . esc_html( $campus ) . '</strong><br><small style="color:#6B7280;">' . esc_html( $prog ) . '</small>';
				break;

			case 'counselor':
				echo esc_html( get_post_meta( $post_id, '_kalalayaa_counselor', true ) );
				break;

			case 'status':
				$status = get_post_meta( $post_id, '_kalalayaa_status', true ) ?: 'New';
				$color = 'New' === $status ? '#38BDF8' : ( 'Contacted' === $status ? '#F59E0B' : '#22C55E' );
				echo '<span style="display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:700; background:' . esc_attr( $color ) . '20; color:' . esc_attr( $color ) . '; border:1px solid ' . esc_attr( $color ) . ';">' . esc_html( $status ) . '</span>';
				break;
		}
	}

	public static function register_meta_boxes() {
		add_meta_box(
			'kalalayaa_inquiry_details',
			__( 'Application Details & Counseling Log', 'kalalayaa-admissions' ),
			array( __CLASS__, 'render_details_box' ),
			'kalalayaa_inquiry',
			'normal',
			'high'
		);
	}

	public static function render_details_box( $post ) {
		wp_nonce_field( 'kalalayaa_inquiry_meta_action', 'kalalayaa_inquiry_nonce' );

		$parent   = get_post_meta( $post->ID, '_kalalayaa_parent_name', true );
		$phone    = get_post_meta( $post->ID, '_kalalayaa_phone', true );
		$email    = get_post_meta( $post->ID, '_kalalayaa_email', true );
		$child    = get_post_meta( $post->ID, '_kalalayaa_child_name', true );
		$age      = get_post_meta( $post->ID, '_kalalayaa_child_age', true );
		$campus   = get_post_meta( $post->ID, '_kalalayaa_campus_name', true );
		$program  = get_post_meta( $post->ID, '_kalalayaa_program', true );
		$status   = get_post_meta( $post->ID, '_kalalayaa_status', true ) ?: 'New';
		$notes    = get_post_meta( $post->ID, '_kalalayaa_notes', true );
		?>
		<table class="form-table">
			<tr>
				<th><label><?php esc_html_e( 'Parent Name:', 'kalalayaa-admissions' ); ?></label></th>
				<td><strong><?php echo esc_html( $parent ); ?></strong></td>
			</tr>
			<tr>
				<th><label><?php esc_html_e( 'Phone / WhatsApp:', 'kalalayaa-admissions' ); ?></label></th>
				<td><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></td>
			</tr>
			<tr>
				<th><label><?php esc_html_e( 'Email:', 'kalalayaa-admissions' ); ?></label></th>
				<td><?php echo esc_html( $email ?: '—' ); ?></td>
			</tr>
			<tr>
				<th><label><?php esc_html_e( 'Child Details:', 'kalalayaa-admissions' ); ?></label></th>
				<td><?php echo esc_html( $child . ' (' . $age . ')' ); ?></td>
			</tr>
			<tr>
				<th><label><?php esc_html_e( 'Target Campus & Program:', 'kalalayaa-admissions' ); ?></label></th>
				<td><?php echo esc_html( $campus . ' — ' . $program ); ?></td>
			</tr>
			<tr>
				<th><label for="kalalayaa_status"><?php esc_html_e( 'Admissions Status:', 'kalalayaa-admissions' ); ?></label></th>
				<td>
					<select name="kalalayaa_status" id="kalalayaa_status">
						<option value="New" <?php selected( $status, 'New' ); ?>>New Lead</option>
						<option value="Contacted" <?php selected( $status, 'Contacted' ); ?>>Contacted</option>
						<option value="Enrolled" <?php selected( $status, 'Enrolled' ); ?>>Enrolled</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="kalalayaa_notes"><?php esc_html_e( 'Counselor Notes:', 'kalalayaa-admissions' ); ?></label></th>
				<td>
					<textarea name="kalalayaa_notes" id="kalalayaa_notes" rows="4" style="width:100%;"><?php echo esc_textarea( $notes ); ?></textarea>
				</td>
			</tr>
		</table>
		<?php
	}

	public static function save_meta( $post_id ) {
		if ( ! isset( $_POST['kalalayaa_inquiry_nonce'] ) || ! wp_verify_nonce( $_POST['kalalayaa_inquiry_nonce'], 'kalalayaa_inquiry_meta_action' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['kalalayaa_status'] ) ) {
			update_post_meta( $post_id, '_kalalayaa_status', sanitize_text_field( $_POST['kalalayaa_status'] ) );
		}

		if ( isset( $_POST['kalalayaa_notes'] ) ) {
			update_post_meta( $post_id, '_kalalayaa_notes', sanitize_textarea_field( $_POST['kalalayaa_notes'] ) );
		}
	}
}
