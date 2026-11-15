<?php
/**
 * Title: Hub Hero
 * Slug: kalalayaa/hub-hero
 * Categories: kalalayaa-hero
 * Description: Clean, emotional opening cover hero featuring Founder Mrs. Dhipikca Rajasekaran and Kalalayaa children.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_image = get_theme_file_uri( 'assets/photos/founder-dhipikca.jpg' );
?>
<section class="m-hub-hero" aria-label="<?php esc_attr_e( 'Welcome to Kalalayaa Schools & Fine Arts', 'kalalayaa' ); ?>">
  <img class="m-hub-hero__bg"
       src="<?php echo esc_url( $hero_image ); ?>"
       alt="<?php esc_attr_e( 'Founder Mrs. Dhipikca Rajasekaran with Kalalayaa students and teachers', 'kalalayaa' ); ?>"
       loading="eager"
       fetchpriority="high"
       width="1424"
       height="772">
  <div class="m-hub-hero__overlay" aria-hidden="true"></div>

  <div class="m-hub-hero__content l-container">
    <span class="m-hub-hero__badge">
      <span class="m-hub-hero__badge-dot" aria-hidden="true"></span>
      <?php esc_html_e( 'Tiruchirappalli • 6 Specialized Campuses', 'kalalayaa' ); ?>
    </span>

    <h1 class="m-hub-hero__title">
      <?php esc_html_e( 'Kalalayaa Schools & Fine Arts', 'kalalayaa' ); ?>
    </h1>

    <p class="m-hub-hero__subtitle">
      <?php esc_html_e( 'Where every child discovers their sacred spark through motherly care & traditional fine arts.', 'kalalayaa' ); ?>
    </p>

    <div class="m-hub-hero__actions">
      <a href="#campuses" class="m-hub-hero__cta m-hub-hero__cta--primary">
        <?php esc_html_e( 'Explore Our 6 Campuses ↓', 'kalalayaa' ); ?>
      </a>
      <a href="#founder-story" class="m-hub-hero__cta m-hub-hero__cta--secondary">
        <?php esc_html_e( 'Our Story & Philosophy', 'kalalayaa' ); ?>
      </a>
    </div>
  </div>

  <a href="#campuses" class="m-hub-hero__scroll-hint" aria-label="<?php esc_attr_e( 'Scroll down to explore campuses', 'kalalayaa' ); ?>">
    <span class="m-hub-hero__scroll-indicator" aria-hidden="true">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="6 9 12 15 18 9"></polyline>
      </svg>
    </span>
  </a>
</section>
