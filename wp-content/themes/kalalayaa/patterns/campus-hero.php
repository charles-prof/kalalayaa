<?php
/**
 * Title: Campus Hero & Gallery
 * Slug: kalalayaa/campus-hero
 * Categories: kalalayaa-campus
 * Description: Immersive full-bleed campus opening cover and horizontal photo gallery.
 *
 * @package Kalalayaa
 */

$campus_id = Kalalayaa_Context::get_current_campus_id();
$campus    = kalalayaa_get_campus( $campus_id );

if ( ! $campus ) {
	$campus = kalalayaa_get_campus( 'kk-nagar' );
}

$gallery_moments = array(
	array(
		'image'   => get_theme_file_uri( 'assets/photos/danceclass.jpg' ),
		'caption' => __( 'Dance & Movement', 'kalalayaa' ),
	),
	array(
		'image'   => get_theme_file_uri( 'assets/photos/bharadanatiyam.jpg' ),
		'caption' => __( 'Bharatanatyam', 'kalalayaa' ),
	),
	array(
		'image'   => get_theme_file_uri( 'assets/photos/annualdayfunctions.jpg' ),
		'caption' => __( 'Annual Day', 'kalalayaa' ),
	),
	array(
		'image'   => get_theme_file_uri( 'assets/photos/finearts.jpg' ),
		'caption' => __( 'Fine Arts', 'kalalayaa' ),
	),
	array(
		'image'   => get_theme_file_uri( 'assets/photos/vocalmusic.jpg' ),
		'caption' => __( 'Vocal Music', 'kalalayaa' ),
	),
	array(
		'image'   => get_theme_file_uri( 'assets/photos/musicclass.jpg' ),
		'caption' => __( 'Music Class', 'kalalayaa' ),
	),
);
?>
<!-- Section A: Full-bleed Emotional Opening Cover -->
<section class="m-campus-cover">
  <img class="m-campus-cover__bg"
       src="<?php echo esc_url( $campus['image'] ); ?>"
       alt="<?php echo esc_attr( $campus['name'] ); ?>"
       loading="eager"
       fetchpriority="high"
       width="1920"
       height="1080">
  <div class="m-campus-cover__overlay" aria-hidden="true"></div>

  <div class="m-campus-cover__content l-container">
    <span class="m-campus-cover__badge"><?php echo esc_html( $campus['badge'] ); ?></span>
    <h1 class="m-campus-cover__title"><?php echo esc_html( $campus['name'] ); ?></h1>
    <p class="m-campus-cover__subtitle"><?php echo esc_html( $campus['subtitle'] ); ?></p>

    <div class="m-campus-cover__actions">
      <a href="#campus-story" class="m-campus-cover__cta m-campus-cover__cta--primary">
        <?php esc_html_e( 'Explore Campus ↓', 'kalalayaa' ); ?>
      </a>
      <a href="#admissions" class="m-campus-cover__cta m-campus-cover__cta--secondary">
        <?php esc_html_e( 'Book a Visit', 'kalalayaa' ); ?>
      </a>
    </div>
  </div>

  <a href="#campus-story" class="m-campus-cover__scroll-hint" aria-label="<?php esc_attr_e( 'Explore Campus', 'kalalayaa' ); ?>">
    <span class="m-campus-cover__scroll-indicator" aria-hidden="true">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="6 9 12 15 18 9"></polyline>
      </svg>
    </span>
  </a>
</section>

<!-- Section B: Campus Life Horizontal Scroll-Snap Photo Gallery -->
<section class="m-campus-gallery" id="campus-story" aria-label="<?php esc_attr_e( 'Campus Life Moments', 'kalalayaa' ); ?>">
  <div class="m-campus-gallery__track" tabindex="0" role="region" aria-label="<?php esc_attr_e( 'Campus Photo Gallery Strip', 'kalalayaa' ); ?>">
    <?php foreach ( $gallery_moments as $index => $item ) : ?>
      <div class="m-campus-gallery__slide" id="campus-slide-<?php echo esc_attr( $index + 1 ); ?>">
        <img class="m-campus-gallery__image"
             src="<?php echo esc_url( $item['image'] ); ?>"
             alt="<?php echo esc_attr( $item['caption'] ); ?>"
             loading="lazy"
             width="800"
             height="450">
        <div class="m-campus-gallery__caption">
          <span><?php echo esc_html( $item['caption'] ); ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="m-campus-gallery__nav" aria-label="<?php esc_attr_e( 'Gallery slide navigation', 'kalalayaa' ); ?>">
    <?php foreach ( $gallery_moments as $index => $item ) : ?>
      <a href="#campus-slide-<?php echo esc_attr( $index + 1 ); ?>"
         class="m-campus-gallery__dot"
         aria-label="<?php echo esc_attr( sprintf( __( 'Jump to slide %d: %s', 'kalalayaa' ), $index + 1, $item['caption'] ) ); ?>">
      </a>
    <?php endforeach; ?>
  </div>

  <div class="m-campus-gallery__breadcrumbs-wrap l-container">
    <nav class="m-campus-gallery__breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'kalalayaa' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="m-campus-gallery__breadcrumbs-link"><?php esc_html_e( 'Home', 'kalalayaa' ); ?></a>
      <span class="m-campus-gallery__breadcrumbs-sep" aria-hidden="true">/</span>
      <a href="<?php echo esc_url( home_url( '/#campuses' ) ); ?>" class="m-campus-gallery__breadcrumbs-link"><?php esc_html_e( 'Campuses', 'kalalayaa' ); ?></a>
      <span class="m-campus-gallery__breadcrumbs-sep" aria-hidden="true">/</span>
      <span class="m-campus-gallery__breadcrumbs-current" aria-current="page"><?php echo esc_html( $campus['name'] ); ?></span>
    </nav>
  </div>
</section>
