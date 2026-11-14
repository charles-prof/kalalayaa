<?php
/**
 * Campus Context Abstraction Engine
 *
 * Provides a unified API for templates to query campus context whether running
 * in Single-Site mode (using query vars & CPTs) or Multisite mode (using blog IDs).
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Kalalayaa_Context {

	/**
	 * Active campus ID cache.
	 *
	 * @var string|null
	 */
	private static $active_campus_id = null;

	/**
	 * Resolves the currently active campus.
	 *
	 * @return array|null The active campus data array or null for global hub.
	 */
	public static function get_current_campus() {
		$campus_id = self::get_current_campus_id();
		if ( ! $campus_id || 'all' === $campus_id ) {
			return null;
		}

		return kalalayaa_get_campus( $campus_id );
	}

	/**
	 * Determines the active campus identifier.
	 *
	 * @return string|null
	 */
	public static function get_current_campus_id() {
		if ( null !== self::$active_campus_id ) {
			return self::$active_campus_id;
		}

		// 1. Multisite Mode Detection
		if ( is_multisite() ) {
			$blog_id = get_current_blog_id();
			// Main site is the hub
			if ( 1 === $blog_id ) {
				self::$active_campus_id = 'all';
				return 'all';
			}

			// Map blog path to campus slug (e.g., /srirangam/ -> 'srirangam')
			$path = trim( get_blog_details( $blog_id )->path, '/' );
			self::$active_campus_id = $path ? $path : 'all';
			return self::$active_campus_id;
		}

		// 2. Single-Site Mode: Check registered query var or direct GET parameter
		$query_campus = get_query_var( 'kalalayaa_campus' );
		if ( empty( $query_campus ) && isset( $_GET['kalalayaa_campus'] ) ) {
			$query_campus = sanitize_key( $_GET['kalalayaa_campus'] );
		}
		if ( ! empty( $query_campus ) ) {
			self::$active_campus_id = sanitize_key( $query_campus );
			return self::$active_campus_id;
		}

		// 3. Single-Site Mode: Check URL path segment (/campuses/{id})
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$request_path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
			if ( preg_match( '#campuses/([a-z0-9-]+)#i', $request_path, $matches ) ) {
				self::$active_campus_id = sanitize_key( $matches[1] );
				return self::$active_campus_id;
			}
		}

		self::$active_campus_id = 'all';
		return 'all';
	}

	/**
	 * Checks if the current view is for a specific campus.
	 *
	 * @param string|null $campus_id Optional specific campus ID to match.
	 * @return bool
	 */
	public static function is_campus_context( $campus_id = null ) {
		$current = self::get_current_campus_id();
		if ( null === $campus_id ) {
			return 'all' !== $current;
		}
		return $current === $campus_id;
	}

	/**
	 * Generates the correct URL to visit a campus page in both Single & Multisite.
	 *
	 * @param string $campus_id
	 * @return string
	 */
	public static function get_campus_url( $campus_id ) {
		if ( is_multisite() ) {
			$blog_id = get_id_from_blogname( $campus_id );
			if ( $blog_id ) {
				return get_home_url( $blog_id, '/' );
			}
		}

		return home_url( '/campuses/' . sanitize_key( $campus_id ) . '/' );
	}
}
