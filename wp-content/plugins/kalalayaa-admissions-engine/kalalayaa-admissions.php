<?php
/**
 * Plugin Name: Kalalayaa Admissions & Smart Routing Engine
 * Plugin URI: https://kalalayaaschools.com/
 * Description: Core admissions CRM, deterministic counselor routing, and Staff Cockpit for Kalalayaa Schools & Fine Arts.
 * Version: 1.0.0
 * Author: CharNithi Software Crafts
 * Author URI: https://charnithi.com/
 * Text Domain: kalalayaa-admissions
 * License: GPLv2 or later
 *
 * @package Kalalayaa_Admissions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KALALAYAA_ADMISSIONS_VERSION', '1.0.0' );
define( 'KALALAYAA_ADMISSIONS_DIR', plugin_dir_path( __FILE__ ) );
define( 'KALALAYAA_ADMISSIONS_URL', plugin_dir_url( __FILE__ ) );

// Load Plugin Subsystems
require_once KALALAYAA_ADMISSIONS_DIR . 'inc/class-inquiry-cpt.php';
require_once KALALAYAA_ADMISSIONS_DIR . 'inc/class-rest-api.php';
require_once KALALAYAA_ADMISSIONS_DIR . 'inc/class-counselor-mailer.php';
require_once KALALAYAA_ADMISSIONS_DIR . 'admin/class-admin-cockpit.php';

/**
 * Initializes the Admissions Engine.
 */
function kalalayaa_admissions_init() {
	Kalalayaa_Inquiry_CPT::init();
	Kalalayaa_REST_API::init();
	Kalalayaa_Counselor_Mailer::init();
	Kalalayaa_Admin_Cockpit::init();
}
add_action( 'plugins_loaded', 'kalalayaa_admissions_init' );

/**
 * Plugin Activation Hook.
 */
register_activation_hook( __FILE__, function () {
	Kalalayaa_Inquiry_CPT::register_cpt();
	flush_rewrite_rules();
} );

/**
 * Plugin Deactivation Hook.
 */
register_deactivation_hook( __FILE__, function () {
	flush_rewrite_rules();
} );
