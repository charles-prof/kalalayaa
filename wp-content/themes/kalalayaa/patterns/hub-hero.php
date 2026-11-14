<?php
/**
 * Title: Hub Hero
 * Slug: kalalayaa/hub-hero
 * Categories: kalalayaa-hero
 * Description: Emotional full-width hero for the hub homepage.
 */

$hero_image = get_theme_file_uri( 'assets/photos/danceclass.jpg' );
?>
<section class="m-hub-hero">
  <img class="m-hub-hero__bg" src="<?php echo esc_url( $hero_image ); ?>" alt="Kalalayaa Children Learning Arts" loading="eager" width="1920" height="750">
  <div class="m-hub-hero__overlay"></div>
  <div class="m-hub-hero__content l-container">
    <h1 class="m-hub-hero__title">Where Every Child Discovers Their Gift</h1>
    <p class="m-hub-hero__subtitle">Six dedicated sanctuaries across Tiruchirappalli — nurturing early childhood learning, classical fine arts, CBSE STEM academics, and athletics with love and motherly care since 2016.</p>
    <div class="m-hub-hero__actions">
      <a href="#campuses" class="m-hub-hero__cta">Explore Our 6 Campuses ↓</a>
    </div>
  </div>
</section>
