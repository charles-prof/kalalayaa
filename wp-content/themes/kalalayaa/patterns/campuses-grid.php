<?php
/**
 * Title: Multi-Campus Explorer Grid
 * Slug: kalalayaa/campuses-grid
 * Categories: kalalayaa-campus
 * Description: Clean, responsive grid displaying all 6 Kalalayaa campuses with authentic photo headers.
 *
 * @package Kalalayaa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$campuses = kalalayaa_get_campus_registry();
?>
<!-- wp:group {"className":"l-section","layout":{"type":"constrained"}} -->
<section class="l-section" id="campuses">
  <div class="l-container">
    <div class="l-section__header">
      <span style="display:inline-flex; align-items:center; gap:6px; padding:4px 14px; border-radius:9999px; background:#EEF7F9; color:#1B3942; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:12px;">
        Our Trichy Network
      </span>
      <h2>One Caring Vision. Six Vibrant Campuses.</h2>
      <p>
        Whether your child is taking first toddler steps in Srirangam, discovering Bharatanatyam in K.K. Nagar, or building robotics at E-Techno — each campus offers dedicated excellence.
      </p>
    </div>

    <div class="l-grid-campuses">
      <?php foreach ( $campuses as $campus_id => $campus ) : ?>
        <article class="m-campus-card <?php echo esc_attr( $campus['theme_class'] ); ?>">
          <div class="m-campus-card__media">
            <img src="<?php echo esc_url( $campus['image'] ); ?>" alt="<?php echo esc_attr( $campus['name'] ); ?> Campus Environment" loading="lazy">
            <span class="m-campus-card__badge-overlay"><?php echo esc_html( $campus['badge'] ); ?></span>
          </div>

          <div class="m-campus-card__accent-line" style="background: <?php echo esc_attr( $campus['accent_color'] ); ?>;"></div>

          <header class="m-campus-card__header">
            <h3 class="m-campus-card__title"><?php echo esc_html( $campus['name'] ); ?></h3>
            <p class="m-campus-card__subtitle"><?php echo esc_html( $campus['subtitle'] ); ?></p>
          </header>

          <div class="m-campus-card__body">
            <p class="m-campus-card__desc"><?php echo esc_html( $campus['description'] ); ?></p>

            <ul class="m-campus-card__features">
              <?php foreach ( $campus['features'] as $feature ) : ?>
                <li>
                  <span class="check-icon">✓</span>
                  <span><?php echo esc_html( $feature ); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>

            <!-- Law of Proximity: Counselor Pill -->
            <div class="m-counselor-pill">
              <div>
                <div class="m-counselor-pill__name"><?php echo esc_html( $campus['counselor'] ); ?></div>
                <div class="m-counselor-pill__role"><?php echo esc_html( $campus['counselor_title'] ); ?></div>
              </div>
              <a href="tel:<?php echo esc_attr( $campus['phone'] ); ?>" class="m-counselor-pill__call" title="<?php esc_attr_e( 'Call Counselor', 'kalalayaa' ); ?>">
                📞
              </a>
            </div>
          </div>

          <footer class="m-campus-card__footer">
            <button class="wp-element-button" style="padding:8px 14px; font-size:13px; background:white; color:#0E2E35; border:1px solid #D6E8EB; border-radius:6px; cursor:pointer;" onclick="window.kalalayaaSelectCampus('<?php echo esc_attr( $campus_id ); ?>')">
              Campus Detail →
            </button>
            <button class="wp-element-button" style="padding:8px 16px; font-size:13px; background:<?php echo esc_attr( $campus['accent_color'] ); ?>; color:white; border-radius:6px; cursor:pointer;" onclick="window.kalalayaaOpenAdmissionsFor('<?php echo esc_attr( $campus_id ); ?>')">
              Apply Here
            </button>
          </footer>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- /wp:group -->
