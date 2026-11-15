<?php
/**
 * Title: Hub Hero
 * Slug: kalalayaa/hub-hero
 * Categories: kalalayaa-hero
 * Description: Full-bleed emotional cover hero for the hub homepage celebrating childhood, arts, and founder vision.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_image = get_theme_file_uri( 'assets/photos/annualdayfunctions.jpg' );
?>
<section class="m-hub-hero" aria-label="Welcome to Kalalayaa Schools &amp; Fine Arts">
  <img class="m-hub-hero__bg"
       src="<?php echo esc_url( $hero_image ); ?>"
       alt="Kalalayaa children performing classical arts with joy on stage"
       loading="eager"
       width="1920"
       height="1080">
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
      Preserving the tender warmth of a mother’s embrace while igniting the fire of classical Indian fine arts, CBSE STEM academics, and athletic discipline across six thriving campuses since 2016.
    </p>

    <!-- Founder Presence Feature Pill -->
    <div class="m-hub-hero__founder">
      <div class="m-hub-hero__founder-avatar" aria-hidden="true">
        <span class="m-hub-hero__founder-initials">DR</span>
      </div>
      <div class="m-hub-hero__founder-text">
        <span class="m-hub-hero__founder-label">Under the Loving Vision of</span>
        <strong class="m-hub-hero__founder-name">Mrs. Dhipikca Rajasekaran</strong>
        <span class="m-hub-hero__founder-role">Co-Founder &amp; Managing Trustee (&ldquo;Aunty&rdquo;)</span>
      </div>
    </div>

    <div class="m-hub-hero__actions">
      <a href="#campuses" class="m-hub-hero__cta m-hub-hero__cta--primary">
        Explore Our 6 Campuses &darr;
      </a>
      <a href="#founder-story" class="m-hub-hero__cta m-hub-hero__cta--secondary">
        Our Founder&rsquo;s Story &amp; Philosophy
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
