<?php
/**
 * Title: Campus Contact & Counselor
 * Slug: kalalayaa/campus-features
 * Categories: kalalayaa-campus
 * Description: Dedicated counselor contact card and location details for the active campus.
 */

$campus_id = Kalalayaa_Context::get_current_campus_id();
$campus    = kalalayaa_get_campus( $campus_id );

if ( ! $campus ) {
	$campus = kalalayaa_get_campus( 'kk-nagar' );
}

$clean_phone = preg_replace( '/[^0-9]/', '', $campus['phone'] );
?>
<section class="m-campus-contact" id="contact">
  <div class="l-container">
    <div class="m-campus-contact__header">
      <span class="m-campus-contact__eyebrow">Personal Support</span>
      <h2 class="m-campus-contact__title">Meet Your Dedicated Campus Team</h2>
      <p class="m-campus-contact__subtitle">We believe admissions is a warm, personal conversation — not an automated queue. Connect directly with our on-campus lead counselor.</p>
    </div>

    <div class="m-campus-contact__grid">
      <div class="m-campus-contact__counselor-card">
        <div class="m-campus-contact__badge-wrap">
          <span class="m-campus-contact__status-pill">Available for Campus Walkthroughs</span>
        </div>
        <h3 class="m-campus-contact__name"><?php echo esc_html( $campus['counselor'] ); ?></h3>
        <p class="m-campus-contact__designation"><?php echo esc_html( $campus['counselor_title'] ); ?></p>
        <p class="m-campus-contact__promise">"I look forward to personally welcoming your family and walking you through our classrooms, our arts wings, and our daily schedule."</p>

        <div class="m-campus-contact__actions">
          <a href="https://wa.me/<?php echo esc_attr( $campus['whatsapp'] ); ?>?text=<?php echo rawurlencode( 'Hello ' . $campus['counselor'] . ', I would like to inquire about admissions at ' . $campus['name'] ); ?>"
             class="m-campus-contact__btn m-campus-contact__btn--whatsapp"
             target="_blank"
             rel="noopener noreferrer">
            <span aria-hidden="true">&#128172;</span> Chat on WhatsApp
          </a>
          <a href="tel:<?php echo esc_attr( $clean_phone ); ?>"
             class="m-campus-contact__btn m-campus-contact__btn--phone">
            <span aria-hidden="true">&#9742;</span> Call <?php echo esc_html( $campus['phone'] ); ?>
          </a>
          <a href="mailto:<?php echo esc_attr( $campus['email'] ); ?>"
             class="m-campus-contact__btn m-campus-contact__btn--email">
            <span aria-hidden="true">&#9993;</span> Email Counselor
          </a>
        </div>
      </div>

      <div class="m-campus-contact__location-card">
        <h3 class="m-campus-contact__location-title">Visit <?php echo esc_html( $campus['name'] ); ?></h3>
        <div class="m-campus-contact__address-block">
          <strong class="m-campus-contact__label">Campus Address:</strong>
          <p class="m-campus-contact__text"><?php echo esc_html( $campus['address'] ); ?></p>
        </div>
        <div class="m-campus-contact__address-block">
          <strong class="m-campus-contact__label">Landmark:</strong>
          <p class="m-campus-contact__text"><?php echo esc_html( $campus['landmark'] ); ?></p>
        </div>
        <div class="m-campus-contact__address-block">
          <strong class="m-campus-contact__label">Visiting Hours:</strong>
          <p class="m-campus-contact__text">Monday &ndash; Saturday: 8:30 AM &ndash; 5:30 PM</p>
        </div>
      </div>
    </div>
  </div>
</section>
