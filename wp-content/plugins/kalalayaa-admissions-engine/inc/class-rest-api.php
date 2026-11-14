<?php
/**
 * REST API Endpoint for Admissions Inquiries
 *
 * Route: POST /wp-json/kalalayaa/v1/inquire
 *
 * @package Kalalayaa_Admissions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Kalalayaa_REST_API {

	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
	}

	public static function register_routes() {
		register_rest_route(
			'kalalayaa/v1',
			'/inquire',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'handle_inquiry' ),
				'permission_callback' => '__return_true', // Public form with validation
			)
		);
	}

	public static function handle_inquiry( WP_REST_Request $request ) {
		$params = $request->get_json_params();

		// Sanitize Inputs
		$parent_name = sanitize_text_field( $params['parent_name'] ?? '' );
		$phone       = sanitize_text_field( $params['phone'] ?? '' );
		$child_name  = sanitize_text_field( $params['child_name'] ?? '' );
		$child_age   = sanitize_text_field( $params['child_age'] ?? '' );
		$email       = sanitize_email( $params['email'] ?? '' );
		$campus_id   = sanitize_key( $params['campus_id'] ?? 'kk-nagar' );
		$program     = sanitize_text_field( $params['program'] ?? '' );
		$notes       = sanitize_textarea_field( $params['notes'] ?? '' );

		if ( empty( $parent_name ) || empty( $phone ) || empty( $child_name ) ) {
			return new WP_Error(
				'missing_fields',
				__( 'Please provide parent name, phone number, and child name.', 'kalalayaa-admissions' ),
				array( 'status' => 400 )
			);
		}

		// Resolve Campus Details from Registry
		$campuses = function_exists( 'kalalayaa_get_campus_registry' ) ? kalalayaa_get_campus_registry() : array();
		$campus = $campuses[ $campus_id ] ?? array(
			'name'      => 'Kalalayaa ' . strtoupper( $campus_id ),
			'counselor' => 'Head Counselor',
			'email'     => 'admissions@kalalayaaschools.com',
			'whatsapp'  => '919443182910',
		);

		// Generate Tracking ID: KL-2026-{CAMPUS}-{RAND}
		$ref_id = sprintf( 'KL-2026-%s-%03d', strtoupper( substr( $campus_id, 0, 3 ) ), wp_rand( 100, 999 ) );

		// Create Inquiry Post
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'kalalayaa_inquiry',
				'post_title'   => $ref_id . ' — ' . $parent_name,
				'post_status'  => 'publish',
				'post_content' => $notes,
			)
		);

		if ( is_wp_error( $post_id ) ) {
			return new WP_Error( 'db_error', __( 'Failed to save application.', 'kalalayaa-admissions' ), array( 'status' => 500 ) );
		}

		// Store Meta
		update_post_meta( $post_id, '_kalalayaa_ref_id', $ref_id );
		update_post_meta( $post_id, '_kalalayaa_parent_name', $parent_name );
		update_post_meta( $post_id, '_kalalayaa_phone', $phone );
		update_post_meta( $post_id, '_kalalayaa_email', $email );
		update_post_meta( $post_id, '_kalalayaa_child_name', $child_name );
		update_post_meta( $post_id, '_kalalayaa_child_age', $child_age );
		update_post_meta( $post_id, '_kalalayaa_campus_id', $campus_id );
		update_post_meta( $post_id, '_kalalayaa_campus_name', $campus['name'] );
		update_post_meta( $post_id, '_kalalayaa_program', $program );
		update_post_meta( $post_id, '_kalalayaa_counselor', $campus['counselor'] );
		update_post_meta( $post_id, '_kalalayaa_status', 'New' );
		update_post_meta( $post_id, '_kalalayaa_notes', $notes );

		// Hook for Email & WhatsApp Dispatch
		do_action( 'kalalayaa_inquiry_received', $post_id, $ref_id, $campus );

		return rest_ensure_response(
			array(
				'success'        => true,
				'inquiry_id'     => $ref_id,
				'post_id'        => $post_id,
				'campus'         => $campus['name'],
				'counselor'      => $campus['counselor'],
				'whatsapp_link'  => 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $campus['whatsapp'] ),
			)
		);
	}
}
