<?php
/**
 * Title: Hub Hero
 * Slug: kalalayaa/hub-hero
 * Categories: kalalayaa-hero
 * Description: Full-bleed emotional cover hero featuring Founder Mrs. Dhipikca Rajasekaran and Kalalayaa children.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_image = get_theme_file_uri( 'assets/photos/founder-dhipikca.jpg' );
?>
<section class="m-hub-hero" aria-label="Welcome to Kalalayaa Schools &amp; Fine Arts">
  <img class="m-hub-hero__bg"
       src="<?php echo esc_url( $hero_image ); ?>"
       alt="Founder Mrs. Dhipikca Rajasekaran with Kalalayaa students"
       loading="eager"
       width="1424"
       height="772">
  <div class="m-hub-hero__overlay" aria-hidden="true"></div>

  <div class="m-hub-hero__content l-container">
    <div class="m-hub-hero__badge-wrap">
      <span class="m-hub-hero__badge">
        <span class="m-hub-hero__badge-dot" aria-hidden="true"></span>
        Tiruchirappalli &bull; 6 Sanctuaries of Learning &amp; Arts
      </span>
    </div>

    <h1 class="m-hub-hero__title">
      Where Every Child Discovers Their Sacred Spark
    </h1>

    <p class="m-hub-hero__subtitle">
      Founded by Mrs. Dhipikca Rajasekaran, Kalalayaa preserves the tender warmth of a mother’s embrace while nurturing classical Indian fine arts, CBSE STEM academics, and athletic discipline across six thriving campuses since 2016.
    </p>

    <div class="m-hub-hero__actions">
      <a href="#campuses" class="m-hub-hero__cta m-hub-hero__cta--primary">
        Explore Our 6 Campuses &darr;
      </a>
      <a href="#founder-story" class="m-hub-hero__cta m-hub-hero__cta--secondary">
        Founder&rsquo;s Story &amp; Philosophy &darr;
      </a>
    </div>
  </div>

  <!-- Animated Scroll Down Indicator -->
  <a href="#campuses" class="m-hub-hero__scroll-hint" aria-label="Scroll to explore campuses">
    <span class="m-hub-hero__scroll-indicator" aria-hidden="true">
      <span class="m-hub-hero__scroll-dot"></span>
    </span>
    <span class="m-hub-hero__scroll-text">Explore Campuses</span>
  </a>
</section>
