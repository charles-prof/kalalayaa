<?php
/**
 * Campus Blog Taxonomy
 *
 * Registers a 'campus' taxonomy on posts so each campus staff
 * can publish events, celebrations, and milestones independently.
 *
 * @package Kalalayaa
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Kalalayaa_Campus_Taxonomy {

    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
        add_action( 'init', array( __CLASS__, 'seed_default_terms' ), 20 );
    }

    public static function register_taxonomy() {
        register_taxonomy( 'campus', array( 'post' ), array(
            'labels'            => array(
                'name'          => __( 'Campuses', 'kalalayaa' ),
                'singular_name' => __( 'Campus', 'kalalayaa' ),
                'menu_name'     => __( 'Campus', 'kalalayaa' ),
                'all_items'     => __( 'All Campuses', 'kalalayaa' ),
                'edit_item'     => __( 'Edit Campus', 'kalalayaa' ),
                'add_new_item'  => __( 'Add Campus', 'kalalayaa' ),
            ),
            'public'            => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'hierarchical'      => true,
            'rewrite'           => array( 'slug' => 'campus', 'hierarchical' => false ),
        ) );
    }

    public static function seed_default_terms() {
        $campuses = array(
            'kk-nagar'      => 'KK Nagar',
            'srirangam'     => 'Srirangam',
            'e-techno'      => 'E-Techno',
            'cantonment'    => 'Cantonment',
            'crawford'      => 'Crawford Colony',
            'kailash-nagar' => 'Kailash Nagar',
        );

        foreach ( $campuses as $slug => $name ) {
            if ( ! term_exists( $slug, 'campus' ) ) {
                wp_insert_term( $name, 'campus', array( 'slug' => $slug ) );
            }
        }
    }
}

Kalalayaa_Campus_Taxonomy::init();
