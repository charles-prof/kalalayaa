<?php
/**
 * Title: Hub Call To Action
 * Slug: kalalayaa/hub-cta
 * Categories: kalalayaa-admissions
 * Description: Balanced, Gestalt-compliant admissions invitation card for the homepage.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="m-hub-cta" aria-label="<?php esc_attr_e( 'Admissions Invitation', 'kalalayaa' ); ?>">
  <div class="l-container">
    <div class="m-hub-cta__card">

      <!-- Header Group (Law of Proximity) -->
      <div class="m-hub-cta__header-group">
        <span class="m-hub-cta__eyebrow">
          <span class="m-hub-cta__eyebrow-dot" aria-hidden="true"></span>
          <?php esc_html_e( 'Admissions Open 2026–2027', 'kalalayaa' ); ?>
        </span>

        <h2 class="m-hub-cta__title">
          <?php esc_html_e( 'Give Your Child the Gift of a Joyful Beginning', 'kalalayaa' ); ?>
        </h2>
      </div>

      <!-- Description -->
      <p class="m-hub-cta__subtitle">
        <?php esc_html_e( 'Experience the classrooms, meet the loving faculty, and feel the energy of Kalalayaa. Schedule a personal walkthrough at any of our 6 Tiruchirappalli campuses.', 'kalalayaa' ); ?>
      </p>

      <!-- Action Group (Harmonious Contrast & Fitts\'s Law) -->
      <div class="m-hub-cta__actions">
        <a href="#campuses" class="m-hub-cta__btn m-hub-cta__btn--primary">
          <?php esc_html_e( 'Select a Campus to Visit →', 'kalalayaa' ); ?>
        </a>
        <a href="tel:+919443182910" class="m-hub-cta__btn m-hub-cta__btn--secondary">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
          <?php esc_html_e( 'Call Central Desk: +91 94431 82910', 'kalalayaa' ); ?>
        </a>
      </div>

      <!-- Trust Note -->
      <p class="m-hub-cta__trust-note">
        <span class="m-hub-cta__trust-icon" aria-hidden="true">🏫</span>
        <?php esc_html_e( 'Walkthroughs & campus tours available Mon – Sat across all 6 branches.', 'kalalayaa' ); ?>
      </p>

    </div>
  </div>
</section>
