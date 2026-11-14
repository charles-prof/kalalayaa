<?php
/**
 * Title: Campus Programs & Features
 * Slug: kalalayaa/campus-programs
 * Categories: kalalayaa-campus
 * Description: Detailed program overview and specialized facilities for the active campus.
 */

$campus_id = Kalalayaa_Context::get_current_campus_id();
$campus    = kalalayaa_get_campus( $campus_id );

if ( ! $campus ) {
	$campus = kalalayaa_get_campus( 'kk-nagar' );
}
?>
<section class="m-campus-programs" id="programs">
  <div class="l-container">
    <div class="m-campus-programs__inner">
      <div class="m-campus-programs__content">
        <span class="m-campus-programs__eyebrow">Distinctive Environment</span>
        <h2 class="m-campus-programs__title">What Makes <?php echo esc_html( $campus['name'] ); ?> Unique</h2>
        <p class="m-campus-programs__desc"><?php echo esc_html( $campus['description'] ); ?></p>

        <div class="m-campus-programs__features-wrap">
          <h3 class="m-campus-programs__features-heading">Campus Highlights &amp; Facilities</h3>
          <ul class="m-campus-programs__features">
            <?php foreach ( $campus['features'] as $feature ) : ?>
              <li class="m-campus-programs__feature">
                <span class="m-campus-programs__check" aria-hidden="true">&#10003;</span>
                <span class="m-campus-programs__feature-text"><?php echo esc_html( $feature ); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="m-campus-programs__media">
        <div class="m-campus-programs__frame">
          <img class="m-campus-programs__img"
               src="<?php echo esc_url( $campus['image'] ); ?>"
               alt="<?php echo esc_attr( $campus['name'] ); ?> Learning Environment"
               loading="lazy"
               width="640"
               height="480">
          <div class="m-campus-programs__caption">
            <strong><?php echo esc_html( $campus['name'] ); ?></strong>
            <span><?php echo esc_html( $campus['landmark'] ); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
