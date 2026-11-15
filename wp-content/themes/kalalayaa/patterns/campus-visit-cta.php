<?php
/**
 * Title: Campus Visit & Counselor Invitation
 * Slug: kalalayaa/campus-visit-cta
 * Categories: kalalayaa-campus
 * Description: Warm closing invitation to book an in-person tour and meet the campus counselor.
 */

$campus_id = Kalalayaa_Context::get_current_campus_id();
$campus    = kalalayaa_get_campus( $campus_id );

if ( ! $campus ) {
	$campus    = kalalayaa_get_campus( 'kk-nagar' );
	$campus_id = 'kk-nagar';
}

$clean_phone    = preg_replace( '/[^0-9+]/', '', $campus['phone'] );
$clean_whatsapp = preg_replace( '/[^0-9]/', '', $campus['whatsapp'] );
$whatsapp_url   = 'https://wa.me/' . $clean_whatsapp . '?text=' . rawurlencode( 'Hello ' . $campus['counselor'] . ', I would like to book a tour and visit ' . $campus['name'] );
?>
<section class="m-campus-visit" id="campus-visit">
  <div class="l-container">
    <div class="m-campus-visit__inner">

      <div class="m-campus-visit__content">
        <h2 class="m-campus-visit__headline">
          Come See <?php echo esc_html( $campus['name'] ); ?> For Yourself
        </h2>
        <p class="m-campus-visit__sub">
          Every campus has its own story. We'd love to show you ours. Book a guided tour and meet our counselor, <?php echo esc_html( $campus['counselor'] ); ?>.
        </p>

        <div class="m-campus-visit__actions">
          <a href="#admissions" class="m-campus-visit__btn m-campus-visit__btn--visit">
            <span aria-hidden="true">&#128197;</span> Book a Visit
          </a>
          <a href="tel:<?php echo esc_attr( $clean_phone ); ?>" class="m-campus-visit__btn m-campus-visit__btn--phone">
            <span aria-hidden="true">&#128222;</span> Call <?php echo esc_html( $campus['phone'] ); ?>
          </a>
          <a href="<?php echo esc_url( $whatsapp_url ); ?>" class="m-campus-visit__btn m-campus-visit__btn--whatsapp" target="_blank" rel="noopener noreferrer">
            <span aria-hidden="true">&#128172;</span> WhatsApp Us
          </a>
        </div>
      </div>

      <div class="m-campus-visit__counselor">
        <div class="m-campus-visit__counselor-frame">
          <div class="m-campus-visit__counselor-avatar" aria-hidden="true">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </div>
          <div class="m-campus-visit__counselor-details">
            <span class="m-campus-visit__counselor-tag">Campus Counselor</span>
            <strong class="m-campus-visit__counselor-name"><?php echo esc_html( $campus['counselor'] ); ?></strong>
            <span class="m-campus-visit__counselor-title"><?php echo esc_html( $campus['counselor_title'] ); ?></span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
