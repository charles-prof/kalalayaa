<?php
/**
 * Title: Campus About & Programs
 * Slug: kalalayaa/campus-about
 * Categories: kalalayaa-campus
 * Description: Warm campus description, at-a-glance stats, and program highlights with icon list.
 */

$campus_id = Kalalayaa_Context::get_current_campus_id();
$campus    = kalalayaa_get_campus( $campus_id );

if ( ! $campus ) {
	$campus    = kalalayaa_get_campus( 'kk-nagar' );
	$campus_id = 'kk-nagar';
}
?>
<section class="m-campus-about" id="campus-about">
  <div class="l-container">

    <!-- Warm introductory lead paragraph -->
    <div class="m-campus-about__lead">
      <span class="m-campus-about__eyebrow">Discover <?php echo esc_html( $campus['name'] ); ?></span>
      <p class="m-campus-about__lead-text">
        <?php echo esc_html( $campus['description'] ); ?>
      </p>
    </div>

    <!-- Campus Life at a Glance stats row -->
    <div class="m-campus-about__stats" aria-label="Campus Life at a Glance">
      <div class="m-campus-about__stat-card">
        <span class="m-campus-about__stat-number"><?php echo esc_html( $campus['established'] ); ?></span>
        <span class="m-campus-about__stat-label">Established</span>
      </div>
      <div class="m-campus-about__stat-card">
        <span class="m-campus-about__stat-number"><?php echo esc_html( $campus['capacity'] ); ?></span>
        <span class="m-campus-about__stat-label">Campus Capacity</span>
      </div>
      <div class="m-campus-about__stat-card">
        <span class="m-campus-about__stat-number"><?php echo esc_html( $campus['care_ratio'] ); ?></span>
        <span class="m-campus-about__stat-label">Teacher Ratio</span>
      </div>
    </div>

    <!-- Programs & Highlights 2-column icon list -->
    <div class="m-campus-about__programs">
      <h2 class="m-campus-about__programs-heading">Campus Highlights &amp; Facilities</h2>
      <ul class="m-campus-about__feature-list">
        <?php foreach ( $campus['features'] as $feature ) : ?>
          <li class="m-campus-about__feature">
            <span class="m-campus-about__feature-icon" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="10" cy="10" r="9" stroke="var(--campus-accent, #0E2E35)" stroke-width="1.75" fill="none"/>
                <path d="M6 10.2L8.7 13L14 7.5" stroke="var(--campus-accent, #0E2E35)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <span class="m-campus-about__feature-text"><?php echo esc_html( $feature ); ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

  </div>
</section>
