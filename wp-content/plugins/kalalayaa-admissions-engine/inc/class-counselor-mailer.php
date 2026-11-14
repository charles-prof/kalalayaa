<?php
/**
 * Counselor Notification Mailer
 *
 * Dispatches deterministic notification emails to assigned campus counselors.
 *
 * @package Kalalayaa_Admissions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Kalalayaa_Counselor_Mailer {

	public static function init() {
		add_action( 'kalalayaa_inquiry_received', array( __CLASS__, 'dispatch_notification' ), 10, 3 );
	}

	public static function dispatch_notification( $post_id, $ref_id, $campus ) {
		$parent  = get_post_meta( $post_id, '_kalalayaa_parent_name', true );
		$phone   = get_post_meta( $post_id, '_kalalayaa_phone', true );
		$email   = get_post_meta( $post_id, '_kalalayaa_email', true );
		$child   = get_post_meta( $post_id, '_kalalayaa_child_name', true );
		$age     = get_post_meta( $post_id, '_kalalayaa_child_age', true );
		$program = get_post_meta( $post_id, '_kalalayaa_program', true );
		$notes   = get_post_meta( $post_id, '_kalalayaa_notes', true );

		$to = ! empty( $campus['email'] ) ? $campus['email'] : get_option( 'admin_email' );
		$subject = sprintf( '[Admissions Lead] New Application for %s — %s (%s)', $campus['name'], $child, $ref_id );

		$message = sprintf(
			"Dear %s,\n\nA new student application has been routed directly to your campus desk.\n\n" .
			"Reference ID: %s\n" .
			"Parent Name: %s\n" .
			"Mobile/WhatsApp: %s\n" .
			"Email: %s\n" .
			"Child: %s (%s)\n" .
			"Program: %s\n" .
			"Special Notes: %s\n\n" .
			"Please contact the parent within 2 hours to confirm their campus walkthrough.\n\n" .
			"— Kalalayaa Digital Campus Engine",
			$campus['counselor'],
			$ref_id,
			$parent,
			$phone,
			$email ?: 'None provided',
			$child,
			$age,
			$program,
			$notes ?: 'None'
		);

		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

		wp_mail( $to, $subject, $message, $headers );
	}
}
