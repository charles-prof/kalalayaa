<?php
/**
 * Kalalayaa Schools & Fine Arts — Theme Engine
 *
 * Authored with human-readable code organization according to WordPress
 * Coding Standards and SMACSS architectural principles.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Load Architecture & Core Abstractions
require_once get_template_directory() . '/inc/campus-registry.php';
require_once get_template_directory() . '/inc/class-campus-context.php';
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Sets up theme defaults and registers support for WordPress features.
 */
function kalalayaa_theme_setup() {
	// Enable translation
	load_theme_textdomain( 'kalalayaa', get_template_directory() . '/languages' );

	// Block Theme & Editor Support
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );

	// Document Title & Thumbnails
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'style', 'script', 'search-form', 'gallery', 'caption' ) );

	// Register Custom Block Pattern Categories
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'kalalayaa-campus',
			array( 'label' => __( 'Kalalayaa: Campuses & Wings', 'kalalayaa' ) )
		);
		register_block_pattern_category(
			'kalalayaa-admissions',
			array( 'label' => __( 'Kalalayaa: Admissions & Forms', 'kalalayaa' ) )
		);
		register_block_pattern_category(
			'kalalayaa-hero',
			array( 'label' => __( 'Kalalayaa: Hero & Highlights', 'kalalayaa' ) )
		);
	}
}
add_action( 'after_setup_theme', 'kalalayaa_theme_setup' );

/**
 * Enqueue front-end stylesheets and vanilla JavaScript modules.
 */
function kalalayaa_enqueue_scripts() {
	// 1. Master SMACSS Stylesheet
	wp_enqueue_style(
		'kalalayaa-theme',
		get_stylesheet_uri(),
		array(),
		'1.0.0'
	);

	// 2. Interactive Navigation & Dropdown Engine
	wp_enqueue_script(
		'kalalayaa-navigation',
		get_theme_file_uri( 'assets/js/navigation.js' ),
		array(),
		'1.0.0',
		true
	);

	// 3. Smart Campus Matcher Logic
	wp_enqueue_script(
		'kalalayaa-matcher',
		get_theme_file_uri( 'assets/js/matcher.js' ),
		array( 'kalalayaa-navigation' ),
		'1.0.0',
		true
	);

	// 4. Admissions Client Engine
	wp_enqueue_script(
		'kalalayaa-admissions',
		get_theme_file_uri( 'assets/js/admissions.js' ),
		array( 'kalalayaa-navigation' ),
		'1.0.0',
		true
	);

	// Localize Application Data for Client-Side JS
	wp_localize_script(
		'kalalayaa-navigation',
		'kalalayaaConfig',
		array(
			'restUrl'       => esc_url_raw( rest_url( 'kalalayaa/v1/' ) ),
			'restNonce'     => wp_create_nonce( 'wp_rest' ),
			'homeUrl'       => esc_url_raw( home_url( '/' ) ),
			'campuses'      => kalalayaa_get_campus_registry(),
			'currentCampus' => Kalalayaa_Context::get_current_campus_id(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'kalalayaa_enqueue_scripts' );

/**
 * Add campus theme context to body classes.
 */
function kalalayaa_body_classes( $classes ) {
	$campus_id = Kalalayaa_Context::get_current_campus_id();
	if ( $campus_id && 'all' !== $campus_id ) {
		$classes[] = 'theme-' . esc_attr( $campus_id );
	}
	return $classes;
}
add_filter( 'body_class', 'kalalayaa_body_classes' );

/**
 * Registers custom rewrite rules for campus micro-sites in Single-Site mode.
 */
function kalalayaa_register_rewrites() {
	add_rewrite_tag( '%kalalayaa_campus%', '([^&/]+)' );
	add_rewrite_rule(
		'^campuses/([^/]+)/?$',
		'index.php?kalalayaa_campus=$matches[1]',
		'top'
	);
}
add_action( 'init', 'kalalayaa_register_rewrites' );
