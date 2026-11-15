<?php
/**
 * Kalalayaa Schools & Fine Arts — Theme Engine
 *
 * Human-readable code following WordPress Coding Standards and SMACSS.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ──────────────────────────────────────────────
   1. Load Architecture & Core Abstractions
   ────────────────────────────────────────────── */
require_once get_template_directory() . '/inc/campus-registry.php';
require_once get_template_directory() . '/inc/class-campus-context.php';
require_once get_template_directory() . '/inc/class-campus-taxonomy.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/class-staff-dashboard.php';
require_once get_template_directory() . '/inc/class-staff-onboarding.php';
require_once get_template_directory() . '/inc/class-login-branding.php';
require_once get_template_directory() . '/inc/class-staff-portal.php';

new Kalalayaa_Staff_Dashboard();
new Kalalayaa_Staff_Onboarding();
new Kalalayaa_Login_Branding();
new Kalalayaa_Staff_Portal();

/* ──────────────────────────────────────────────
   2. Theme Setup
   ────────────────────────────────────────────── */
function kalalayaa_theme_setup() {
    load_theme_textdomain( 'kalalayaa', get_template_directory() . '/languages' );

    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'style.css' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'html5', array( 'style', 'script', 'search-form', 'gallery', 'caption' ) );

    if ( function_exists( 'register_block_pattern_category' ) ) {
        register_block_pattern_category( 'kalalayaa-campus', array(
            'label' => __( 'Kalalayaa: Campuses', 'kalalayaa' ),
        ) );
        register_block_pattern_category( 'kalalayaa-admissions', array(
            'label' => __( 'Kalalayaa: Admissions', 'kalalayaa' ),
        ) );
        register_block_pattern_category( 'kalalayaa-hero', array(
            'label' => __( 'Kalalayaa: Hero & Highlights', 'kalalayaa' ),
        ) );
    }
}
add_action( 'after_setup_theme', 'kalalayaa_theme_setup' );

/* ──────────────────────────────────────────────
   3. Enqueue Stylesheets & Scripts
   ────────────────────────────────────────────── */
function kalalayaa_enqueue_scripts() {
    wp_enqueue_style( 'kalalayaa-theme', get_stylesheet_uri(), array(), '2.0.0' );
    wp_enqueue_style( 'kalalayaa-campus-cover', get_theme_file_uri( 'assets/css/modules/campus-cover.css' ), array( 'kalalayaa-theme' ), '2.0.0' );
    wp_enqueue_style( 'kalalayaa-campus-gallery', get_theme_file_uri( 'assets/css/modules/campus-gallery.css' ), array( 'kalalayaa-theme' ), '2.0.0' );

    wp_enqueue_style(
        'kalalayaa-campus-about',
        get_theme_file_uri( 'assets/css/modules/campus-about.css' ),
        array( 'kalalayaa-theme' ),
        '2.0.0'
    );

    wp_enqueue_style(
        'kalalayaa-campus-news',
        get_theme_file_uri( 'assets/css/modules/campus-news.css' ),
        array( 'kalalayaa-theme' ),
        '2.0.0'
    );

    wp_enqueue_style(
        'kalalayaa-campus-visit',
        get_theme_file_uri( 'assets/css/modules/campus-visit.css' ),
        array( 'kalalayaa-theme' ),
        '2.0.0'
    );

    wp_enqueue_script(
        'kalalayaa-navigation',
        get_theme_file_uri( 'assets/js/navigation.js' ),
        array(),
        '2.0.0',
        true
    );

    wp_enqueue_script(
        'kalalayaa-campus-page',
        get_theme_file_uri( 'assets/js/campus-page.js' ),
        array( 'kalalayaa-navigation' ),
        '2.0.0',
        true
    );

    wp_enqueue_script(
        'kalalayaa-admissions',
        get_theme_file_uri( 'assets/js/admissions.js' ),
        array( 'kalalayaa-navigation' ),
        '2.0.0',
        true
    );

    wp_localize_script( 'kalalayaa-navigation', 'kalalayaaConfig', array(
        'restUrl'       => esc_url_raw( rest_url( 'kalalayaa/v1/' ) ),
        'restNonce'     => wp_create_nonce( 'wp_rest' ),
        'homeUrl'       => esc_url_raw( home_url( '/' ) ),
        'campuses'      => kalalayaa_get_campus_registry(),
        'currentCampus' => Kalalayaa_Context::get_current_campus_id(),
    ) );
}
add_action( 'wp_enqueue_scripts', 'kalalayaa_enqueue_scripts' );

/* ──────────────────────────────────────────────
   4. Campus Body Classes
   ────────────────────────────────────────────── */
function kalalayaa_body_classes( $classes ) {
    $campus_id = Kalalayaa_Context::get_current_campus_id();
    if ( $campus_id && 'all' !== $campus_id ) {
        $classes[] = 'theme-' . sanitize_html_class( $campus_id );
        $classes[] = 'is-campus-page';
    }
    return $classes;
}
add_filter( 'body_class', 'kalalayaa_body_classes' );

/* ──────────────────────────────────────────────
   5. Campus Rewrite Rules
   ────────────────────────────────────────────── */
function kalalayaa_register_rewrites() {
    add_rewrite_tag( '%kalalayaa_campus%', '([^&/]+)' );
    add_rewrite_rule(
        '^campuses/([^/]+)/?$',
        'index.php?kalalayaa_campus=$matches[1]',
        'top'
    );
}
add_action( 'init', 'kalalayaa_register_rewrites' );

/* ──────────────────────────────────────────────
   6. Campus Template Routing
   ────────────────────────────────────────────── */
function kalalayaa_campus_template( $template ) {
    $campus_id = get_query_var( 'kalalayaa_campus' );
    if ( empty( $campus_id ) && isset( $_GET['kalalayaa_campus'] ) ) {
        $campus_id = sanitize_key( $_GET['kalalayaa_campus'] );
    }
    if ( ! empty( $campus_id ) && 'all' !== $campus_id ) {
        Kalalayaa_Context::reset();
        set_query_var( 'kalalayaa_campus', $campus_id );
        $campus_wrapper = get_theme_file_path( 'campus-template.php' );
        if ( file_exists( $campus_wrapper ) ) {
            return $campus_wrapper;
        }
    }
    return $template;
}
add_filter( 'template_include', 'kalalayaa_campus_template', 5 );

/* ──────────────────────────────────────────────
   7. Dynamic Document Title for Campus Pages
   ────────────────────────────────────────────── */
function kalalayaa_campus_document_title( $title ) {
    $campus_id = Kalalayaa_Context::get_current_campus_id();
    if ( $campus_id && 'all' !== $campus_id ) {
        $campus = kalalayaa_get_campus( $campus_id );
        if ( $campus ) {
            $title['title'] = $campus['name'] . ' — ' . $campus['subtitle'];
        }
    }
    return $title;
}
add_filter( 'document_title_parts', 'kalalayaa_campus_document_title' );

/* ──────────────────────────────────────────────
   8. Redirect Legacy /blog/ to /news-events/
   ────────────────────────────────────────────── */
function kalalayaa_redirect_legacy_blog() {
    if ( is_admin() || wp_doing_ajax() ) {
        return;
    }
    $path = trim( parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
    if ( 'blog' === $path ) {
        wp_safe_redirect( home_url( '/news-events/' ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'kalalayaa_redirect_legacy_blog', 1 );
