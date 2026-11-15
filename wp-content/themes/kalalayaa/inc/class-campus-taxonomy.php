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
        add_action( 'admin_init', array( __CLASS__, 'seed_editor_campus_meta' ) );
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

    /**
     * Auto-assign _kalalayaa_campus_id user meta for existing editor staff.
     *
     * One-time auto-assignment on admin_init. If an editor user does not have
     * _kalalayaa_campus_id set, checks user_login patterns (e.g. editor_srirangam -> srirangam)
     * and seeds the meta.
     *
     * @return void
     */
    public static function seed_editor_campus_meta() {
        // Query users with editor role
        $editors = get_users( array( 'role' => 'editor' ) );
        if ( empty( $editors ) ) {
            $editors = get_users();
        }

        $campus_map = array(
            'kk-nagar'      => array( 'kk-nagar', 'kknagar', 'kk_nagar', 'kk' ),
            'srirangam'     => array( 'srirangam' ),
            'e-techno'      => array( 'e-techno', 'etechno', 'e_techno', 'techno' ),
            'cantonment'    => array( 'cantonment' ),
            'crawford'      => array( 'crawford' ),
            'kailash-nagar' => array( 'kailash-nagar', 'kailashnagar', 'kailash_nagar', 'kailash' ),
        );

        foreach ( $editors as $user ) {
            // Never assign campus to administrators
            if ( in_array( 'administrator', (array) $user->roles, true ) || 'charnithi_admin' === $user->user_login ) {
                continue;
            }

            $existing = get_user_meta( $user->ID, '_kalalayaa_campus_id', true );
            if ( ! empty( $existing ) ) {
                continue;
            }

            $login    = strtolower( $user->user_login );
            $nicename = strtolower( $user->user_nicename );
            $display  = strtolower( $user->display_name );

            $matched_campus = null;
            foreach ( $campus_map as $slug => $patterns ) {
                foreach ( $patterns as $pattern ) {
                    if ( false !== strpos( $login, $pattern ) || false !== strpos( $nicename, $pattern ) || false !== strpos( $display, $pattern ) ) {
                        $matched_campus = $slug;
                        break 2;
                    }
                }
            }

            if ( $matched_campus ) {
                update_user_meta( $user->ID, '_kalalayaa_campus_id', $matched_campus );
            }
        }
    }
}

Kalalayaa_Campus_Taxonomy::init();
