<?php
/**
 * Title: Campus Hero
 * Slug: kalalayaa/campus-hero
 * Categories: kalalayaa-campus
 * Description: Dynamic campus landing page hero driven by the campus registry.
 */

$campus_id = Kalalayaa_Context::get_current_campus_id();
$campus    = kalalayaa_get_campus( $campus_id );

if ( ! $campus ) {
	$campus = kalalayaa_get_campus( 'kk-nagar' );
}
?>
<section class="m-campus-hero">
  <img class="m-campus-hero__bg"
       src="<?php echo esc_url( $campus['image'] ); ?>"
       alt="<?php echo esc_attr( $campus['name'] ); ?>"
       loading="eager"
       width="1920"
       height="750">
  <div class="m-campus-hero__overlay"></div>
  <div class="m-campus-hero__content l-container">
    <div class="m-campus-hero__breadcrumbs">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
      <span class="m-campus-hero__separator">/</span>
      <a href="<?php echo esc_url( home_url( '/#campuses' ) ); ?>">Campuses</a>
      <span class="m-campus-hero__separator">/</span>
      <span class="m-campus-hero__current"><?php echo esc_html( $campus['name'] ); ?></span>
    </div>

    <span class="m-campus-hero__badge"><?php echo esc_html( $campus['badge'] ); ?></span>
    <h1 class="m-campus-hero__title"><?php echo esc_html( $campus['name'] ); ?></h1>
    <p class="m-campus-hero__subtitle"><?php echo esc_html( $campus['subtitle'] ); ?></p>

    <div class="m-campus-hero__stats">
      <div class="m-campus-hero__stat">
        <span class="m-campus-hero__stat-label">Established</span>
        <strong class="m-campus-hero__stat-value"><?php echo esc_html( $campus['established'] ); ?></strong>
      </div>
      <div class="m-campus-hero__stat-divider"></div>
      <div class="m-campus-hero__stat">
        <span class="m-campus-hero__stat-label">Campus Capacity</span>
        <strong class="m-campus-hero__stat-value"><?php echo esc_html( $campus['capacity'] ); ?></strong>
      </div>
      <div class="m-campus-hero__stat-divider"></div>
      <div class="m-campus-hero__stat">
        <span class="m-campus-hero__stat-label">Teacher-Child Ratio</span>
        <strong class="m-campus-hero__stat-value"><?php echo esc_html( $campus['care_ratio'] ); ?></strong>
      </div>
    </div>

    <div class="m-campus-hero__actions">
      <a href="#admissions" class="m-campus-hero__cta">Apply to This Campus ↓</a>
      <a href="#contact" class="m-campus-hero__cta m-campus-hero__cta--outline">Meet Counselor &amp; Visit</a>
    </div>
  </div>
</section>
