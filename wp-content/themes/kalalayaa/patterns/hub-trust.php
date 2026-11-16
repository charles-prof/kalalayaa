<?php
/**
 * Title: Hub Trust & Founder Story
 * Slug: kalalayaa/hub-trust
 * Categories: kalalayaa-hero
 * Description: Unified founder sanctuary showcasing Mrs. Dhipikca Rajasekaran's vision, maternal pledge, and continuous trust ribbon.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$founder_photo = get_theme_file_uri( 'assets/photos/founder-dhipikca.jpg' );
?>
<section class="m-trust" id="founder-story" aria-label="<?php esc_attr_e( 'Founder Story and Educational Philosophy', 'kalalayaa' ); ?>">
  <div class="l-container">

    <!-- Section Header -->
    <div class="m-trust__header">
      <span class="m-trust__eyebrow"><?php esc_html_e( 'Our Living Philosophy • Tiruchirappalli', 'kalalayaa' ); ?></span>
      <h2 class="m-trust__title"><?php esc_html_e( 'Rooted in Culture. Inspired by Love.', 'kalalayaa' ); ?></h2>
      <p class="m-trust__subtitle">
        <?php esc_html_e( 'Kalalayaa was born from a mother’s sacred promise: that no child should ever have to choose between modern academic excellence and cultural soul.', 'kalalayaa' ); ?>
      </p>
    </div>

    <!-- Unified Founder Sanctuary Card -->
    <div class="m-trust__sanctuary">

      <!-- Sanctuary Main Story Body -->
      <div class="m-trust__body">

        <!-- Left Column: Portrait & Founder Credibility -->
        <div class="m-trust__portrait-col">
          <div class="m-trust__portrait-frame">
            <img class="m-trust__portrait-img"
                 src="<?php echo esc_url( $founder_photo ); ?>"
                 alt="<?php esc_attr_e( 'Mrs. Dhipikca Rajasekaran nurturing students at Kalalayaa', 'kalalayaa' ); ?>"
                 loading="lazy"
                 width="600"
                 height="600">
          </div>
          <div class="m-trust__founder-meta">
            <h3 class="m-trust__founder-name"><?php esc_html_e( 'Mrs. Dhipikca Rajasekaran', 'kalalayaa' ); ?></h3>
            <p class="m-trust__founder-title"><?php esc_html_e( 'Founder & Managing Trustee (“Aunty”)', 'kalalayaa' ); ?></p>
            <p class="m-trust__founder-note">
              <?php esc_html_e( 'Devoted over a decade across Tiruchirappalli to crafting sanctuaries where classical arts and tender emotional security walk hand in hand.', 'kalalayaa' ); ?>
            </p>
          </div>
        </div>

        <!-- Right Column: Maternal Pledge & Vision -->
        <div class="m-trust__story-col">
          <div class="m-trust__pledge-mark" aria-hidden="true">“</div>
          <blockquote class="m-trust__quote">
            <?php esc_html_e( 'Every child who walks through our doors is not just a student; they are our sacred trust. We preserve the warmth of a mother’s embrace while igniting the spark of discipline, cultural rootedness, and modern scientific inquiry.', 'kalalayaa' ); ?>
          </blockquote>
          <p class="m-trust__narrative">
            <?php esc_html_e( 'From our very first dance step in KK Nagar to six flourishing sanctuaries across Trichy, our promise has never wavered: your child will always be known by name, cherished for their uniqueness, and inspired to reach their highest potential with confidence and grace.', 'kalalayaa' ); ?>
          </p>
          <div class="m-trust__signature-block">
            <span class="m-trust__signature-name"><?php esc_html_e( 'Dhipikca Rajasekaran', 'kalalayaa' ); ?></span>
            <span class="m-trust__signature-title"><?php esc_html_e( 'Managing Trustee • Kalalayaa Schools & Fine Arts', 'kalalayaa' ); ?></span>
          </div>
        </div>

      </div>

      <!-- Bottom Trust Ribbon (Continuous Hairline Metrics) -->
      <div class="m-trust__ribbon" aria-label="<?php esc_attr_e( 'Institutional Milestones', 'kalalayaa' ); ?>">
        <div class="m-trust__ribbon-item">
          <strong class="m-trust__ribbon-number"><?php esc_html_e( '10+ Years', 'kalalayaa' ); ?></strong>
          <span class="m-trust__ribbon-label"><?php esc_html_e( 'Sacred Cultural Heritage', 'kalalayaa' ); ?></span>
          <span class="m-trust__ribbon-sub"><?php esc_html_e( 'Established 2016', 'kalalayaa' ); ?></span>
        </div>
        <div class="m-trust__ribbon-divider" aria-hidden="true"></div>
        <div class="m-trust__ribbon-item">
          <strong class="m-trust__ribbon-number"><?php esc_html_e( '6 Campuses', 'kalalayaa' ); ?></strong>
          <span class="m-trust__ribbon-label"><?php esc_html_e( 'Across Tiruchirappalli', 'kalalayaa' ); ?></span>
          <span class="m-trust__ribbon-sub"><?php esc_html_e( 'Specialized Sanctuaries', 'kalalayaa' ); ?></span>
        </div>
        <div class="m-trust__ribbon-divider" aria-hidden="true"></div>
        <div class="m-trust__ribbon-item">
          <strong class="m-trust__ribbon-number"><?php esc_html_e( '1,400+', 'kalalayaa' ); ?></strong>
          <span class="m-trust__ribbon-label"><?php esc_html_e( 'Children Nurtured', 'kalalayaa' ); ?></span>
          <span class="m-trust__ribbon-sub"><?php esc_html_e( 'Early Years to High School', 'kalalayaa' ); ?></span>
        </div>
        <div class="m-trust__ribbon-divider" aria-hidden="true"></div>
        <div class="m-trust__ribbon-item">
          <strong class="m-trust__ribbon-number"><?php esc_html_e( '1:8 Ratio', 'kalalayaa' ); ?></strong>
          <span class="m-trust__ribbon-label"><?php esc_html_e( 'Attentive Care Ratio', 'kalalayaa' ); ?></span>
          <span class="m-trust__ribbon-sub"><?php esc_html_e( 'Motherly Teacher Mentorship', 'kalalayaa' ); ?></span>
        </div>
      </div>

    </div>

  </div>
</section>
