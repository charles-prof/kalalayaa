<?php
/**
 * Title: Fine Arts Academy Showcase
 * Slug: kalalayaa/fine-arts-grid
 * Categories: kalalayaa-campus
 * Description: Displays the 9 cultural and fine arts disciplines with authentic photos.
 *
 * @package Kalalayaa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$disciplines = kalalayaa_get_fine_arts_disciplines();
?>
<!-- wp:group {"className":"l-section","layout":{"type":"constrained"}} -->
<section class="l-section" id="fine-arts">
  <div class="l-container">
    <div class="l-section__header">
      <span style="display:inline-flex; align-items:center; gap:6px; padding:4px 14px; border-radius:9999px; background:#EEF7F9; color:#1B3942; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:12px;">
        Kalalayaa Fine Arts Academy
      </span>
      <h2>Nurturing the Artist & Thinker Within</h2>
      <p>
        Beyond academics, every child carries a unique creative genius. Our weekend and evening academies offer professional mentorship in Bharatanatyam, Carnatic Music, Keyboard, Robotics, and Speedcubing.
      </p>
    </div>

    <div class="l-grid-arts">
      <?php foreach ( $disciplines as $art ) : ?>
        <article class="m-arts-card">
          <?php if ( ! empty( $art['image'] ) ) : ?>
            <div class="m-arts-card__media">
              <img src="<?php echo esc_url( $art['image'] ); ?>" alt="<?php echo esc_attr( $art['title'] ); ?>" loading="lazy">
            </div>
          <?php endif; ?>

          <div class="m-arts-card__category"><?php echo esc_html( $art['category'] ); ?> · <?php echo esc_html( $art['age'] ); ?></div>
          <h3 class="m-arts-card__name"><?php echo esc_html( $art['title'] ); ?></h3>
          <p class="m-arts-card__desc"><?php echo esc_html( $art['desc'] ); ?></p>
          <div class="m-arts-card__campuses">
            Offered at: <strong><?php echo esc_html( implode( ', ', $art['campuses'] ) ); ?></strong>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- /wp:group -->
