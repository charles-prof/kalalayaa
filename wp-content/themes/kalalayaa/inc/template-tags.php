<?php
/**
 * Custom Template Tags and Helpers
 *
 * Semantic, human-readable helper functions for templates and block patterns.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the currently active campus data array or null.
 *
 * @return array|null
 */
function kalalayaa_get_current_campus() {
	return Kalalayaa_Context::get_current_campus();
}

/**
 * Generates an encrypted/safe direct WhatsApp chat link to a campus counselor.
 *
 * @param array $campus
 * @param string $custom_message Optional initial pre-filled text.
 * @return string
 */
function kalalayaa_get_counselor_whatsapp_link( $campus, $custom_message = '' ) {
	if ( empty( $campus['whatsapp'] ) ) {
		return 'https://wa.me/919443182910';
	}

	$default_msg = sprintf(
		/* translators: 1: Counselor Name, 2: Campus Name */
		__( 'Hello %1$s, I would like to inquire about admissions for my child at %2$s.', 'kalalayaa' ),
		$campus['counselor'],
		$campus['name']
	);

	$message = ! empty( $custom_message ) ? $custom_message : $default_msg;
	return 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $campus['whatsapp'] ) . '?text=' . rawurlencode( $message );
}

/**
 * Returns the 9 authentic fine arts disciplines.
 *
 * @return array
 */
function kalalayaa_get_fine_arts_disciplines() {
	return array(
		array(
			'id'        => 'bharatanatyam',
			'title'     => __( 'Classical Bharatanatyam', 'kalalayaa' ),
			'category'  => __( 'Performing Arts', 'kalalayaa' ),
			'age'       => __( 'Ages 4+', 'kalalayaa' ),
			'image'     => get_theme_file_uri( 'assets/photos/bharadanatiyam.jpg' ),
			'desc'      => __( 'Rooted in timeless Tamil heritage. Our master gurus guide students through Adavus, Mudras, and Abhinaya.', 'kalalayaa' ),
			'campuses'  => array( 'KK Nagar', 'Srirangam', 'Kailash Nagar', 'Cantonment' ),
		),
		array(
			'id'        => 'carnatic',
			'title'     => __( 'Carnatic Vocal & Slokas', 'kalalayaa' ),
			'category'  => __( 'Vocal Arts', 'kalalayaa' ),
			'age'       => __( 'Ages 4+', 'kalalayaa' ),
			'image'     => get_theme_file_uri( 'assets/photos/vocalmusic.jpg' ),
			'desc'      => __( 'Voice culture, Sarali Varisai, and soulful Sanskrit & Tamil slokas nurturing cognitive memory and cultural reverence.', 'kalalayaa' ),
			'campuses'  => array( 'KK Nagar', 'Srirangam', 'Kailash Nagar' ),
		),
		array(
			'id'        => 'keyboard',
			'title'     => __( 'Western & Melodic Keyboard', 'kalalayaa' ),
			'category'  => __( 'Instrumental', 'kalalayaa' ),
			'age'       => __( 'Ages 5+', 'kalalayaa' ),
			'image'     => get_theme_file_uri( 'assets/photos/musicclass.jpg' ),
			'desc'      => __( 'Structured fingering techniques, staff notation, and Trinity College London progressive syllabus preparation.', 'kalalayaa' ),
			'campuses'  => array( 'KK Nagar', 'Crawford', 'E-Techno', 'Cantonment' ),
		),
		array(
			'id'        => 'drawing',
			'title'     => __( 'Drawing, Painting & Clay Craft', 'kalalayaa' ),
			'category'  => __( 'Visual Arts', 'kalalayaa' ),
			'age'       => __( 'Ages 3.5+', 'kalalayaa' ),
			'image'     => get_theme_file_uri( 'assets/photos/finearts.jpg' ),
			'desc'      => __( 'Unlocking raw creativity through oil pastels, acrylics, water painting, and therapeutic clay modeling.', 'kalalayaa' ),
			'campuses'  => array( 'All 6 Campuses' ),
		),
		array(
			'id'        => 'speedcubing',
			'title'     => __( 'Rubik’s Cube Speedcubing', 'kalalayaa' ),
			'category'  => __( 'Mental Gymnastics', 'kalalayaa' ),
			'age'       => __( 'Ages 5+', 'kalalayaa' ),
			'image'     => get_theme_file_uri( 'assets/photos/danceclass.jpg' ),
			'desc'      => __( 'Algorithmic pattern recognition from 2x2 to 5x5, Megaminx, and Pyraminx. Trains spatial intelligence and speed.', 'kalalayaa' ),
			'campuses'  => array( 'KK Nagar', 'E-Techno', 'Srirangam' ),
		),
		array(
			'id'        => 'robotics',
			'title'     => __( 'Robotics & STEM Innovation', 'kalalayaa' ),
			'category'  => __( 'Science & Tech', 'kalalayaa' ),
			'age'       => __( 'Ages 7+', 'kalalayaa' ),
			'image'     => get_theme_file_uri( 'assets/photos/annualdayfunctions.jpg' ),
			'desc'      => __( 'Block-based coding, Arduino microcontrollers, sensory robotics, and 21st-century problem-solving.', 'kalalayaa' ),
			'campuses'  => array( 'Kalalayaa E-Techno School' ),
		),
	);
}
