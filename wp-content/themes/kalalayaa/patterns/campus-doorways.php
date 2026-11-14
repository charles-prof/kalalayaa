<?php
/**
 * Title: Campus Doorways
 * Slug: kalalayaa/campus-doorways
 * Categories: kalalayaa-campus
 * Description: Visual grid of 6 campus cards linking to individual campus landing pages.
 */

$campuses = kalalayaa_get_campus_registry();
?>
<section class="m-doorways" id="campuses">
  <div class="l-container">
    <div class="m-doorways__header">
      <span class="m-doorways__eyebrow">Six Sanctuaries in Tiruchirappalli</span>
      <h2 class="m-doorways__title">Choose Your Nearest Campus</h2>
      <p class="m-doorways__subtitle">Every campus is thoughtfully crafted with its own distinct atmosphere, faculty, and focus — from traditional fine arts in Srirangam to future-ready robotics in E-Techno.</p>
    </div>

    <div class="m-doorways__grid">
      <?php foreach ( $campuses as $id => $campus ) : ?>
        <a href="<?php echo esc_url( home_url( '/campuses/' . $id . '/' ) ); ?>"
           class="m-doorway-card"
           style="--campus-accent: <?php echo esc_attr( $campus['accent_color'] ); ?>;">
          <div class="m-doorway-card__image-wrap">
            <img class="m-doorway-card__image"
                 src="<?php echo esc_url( $campus['image'] ); ?>"
                 alt="<?php echo esc_attr( $campus['name'] ); ?>"
                 loading="lazy"
                 width="400"
                 height="250">
            <span class="m-doorway-card__badge"><?php echo esc_html( $campus['badge'] ); ?></span>
          </div>
          <div class="m-doorway-card__accent-bar"></div>
          <div class="m-doorway-card__body">
            <h3 class="m-doorway-card__name"><?php echo esc_html( $campus['name'] ); ?></h3>
            <p class="m-doorway-card__subtitle"><?php echo esc_html( $campus['subtitle'] ); ?></p>
            <div class="m-doorway-card__meta">
              <span class="m-doorway-card__stat">Est. <?php echo esc_html( $campus['established'] ); ?></span>
              <span class="m-doorway-card__dot">·</span>
              <span class="m-doorway-card__stat"><?php echo esc_html( $campus['care_ratio'] ); ?></span>
            </div>
            <span class="m-doorway-card__cta">Explore Campus &amp; Programs →</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
