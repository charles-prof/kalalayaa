<?php
/**
 * Title: Hub Trust & Founder Story
 * Slug: kalalayaa/hub-trust
 * Categories: kalalayaa-hero
 * Description: Dedicated founder sanctuary showcasing Mrs. Dhipikca Rajasekaran's vision, philosophy, and institutional trust metrics.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$founder_photo = get_theme_file_uri( 'assets/photos/danceclass.jpg' );
?>
<section class="m-trust" id="founder-story" aria-label="Founder Story and Educational Philosophy">
  <div class="l-container">
    <div class="m-trust__header">
      <span class="m-trust__eyebrow">Our Living Philosophy &bull; Tiruchirappalli</span>
      <h2 class="m-trust__title">Rooted in Culture. Inspired by Love.</h2>
      <p class="m-trust__subtitle">
        Kalalayaa was born from a mother&rsquo;s sacred promise: that no child should ever have to choose between modern excellence and cultural soul.
      </p>
    </div>

    <div class="m-trust__grid">
      <!-- Left Column: Founder Portrait & Credibility Card -->
      <div class="m-trust__founder-card">
        <div class="m-trust__portrait-frame">
          <img class="m-trust__portrait-img"
               src="<?php echo esc_url( $founder_photo ); ?>"
               alt="Mrs. Dhipikca Rajasekaran nurturing students at Kalalayaa"
               loading="lazy"
               width="600"
               height="600">
          <div class="m-trust__portrait-overlay" aria-hidden="true"></div>
          <div class="m-trust__portrait-badge">
            <span class="m-trust__portrait-badge-icon" aria-hidden="true">&#9829;</span>
            <span class="m-trust__portrait-badge-text">Motherly Care Since 2016</span>
          </div>
        </div>

        <div class="m-trust__founder-details">
          <h3 class="m-trust__founder-name">Mrs. Dhipikca Rajasekaran</h3>
          <p class="m-trust__founder-title">Co-Founder &amp; Managing Trustee (&ldquo;Aunty&rdquo;)</p>
          <p class="m-trust__founder-bio">
            Known affectionately across Tiruchirappalli as &ldquo;Aunty,&rdquo; Mrs. Dhipikca has devoted over a decade to crafting educational sanctuaries where discipline in classical arts and tender emotional security walk hand in hand.
          </p>
          <div class="m-trust__seal">
            <span class="m-trust__seal-icon" aria-hidden="true">&#10022;</span>
            <span class="m-trust__seal-text">Kalalayaa Institutions &bull; 6 Campuses in Trichy</span>
          </div>
        </div>
      </div>

      <!-- Right Column: Founder's Sacred Voice & Institutional Credibility -->
      <div class="m-trust__voice-card">
        <div class="m-trust__quote-box">
          <span class="m-trust__glyph" aria-hidden="true">&ldquo;</span>
          <blockquote class="m-trust__quote">
            Every child who walks through our doors is not just a student; they are our sacred trust. We preserve the warmth of a mother’s embrace while igniting the spark of discipline, cultural rootedness, and modern scientific inquiry.
          </blockquote>
          <p class="m-trust__voice-paragraph">
            From our very first dance step in KK Nagar to six flourishing academies across Trichy, our promise has never wavered: your child will always be known by name, cherished for their uniqueness, and inspired to reach their highest potential with confidence and grace.
          </p>
          <div class="m-trust__signature-wrap">
            <span class="m-trust__signature-name">Dhipikca Rajasekaran</span>
            <span class="m-trust__signature-title">Managing Trustee &bull; Kalalayaa Schools &amp; Fine Arts</span>
          </div>
        </div>

        <!-- 4 Credibility Metric Cards -->
        <div class="m-trust__stats-grid" aria-label="Kalalayaa Impact Metrics">
          <div class="m-trust__stat-card">
            <strong class="m-trust__stat-number">10+</strong>
            <span class="m-trust__stat-label">Years of Cultural Heritage</span>
            <span class="m-trust__stat-sub">Established 2016</span>
          </div>
          <div class="m-trust__stat-card">
            <strong class="m-trust__stat-number">6</strong>
            <span class="m-trust__stat-label">Specialized Campuses</span>
            <span class="m-trust__stat-sub">Across Tiruchirappalli</span>
          </div>
          <div class="m-trust__stat-card">
            <strong class="m-trust__stat-number">1,400+</strong>
            <span class="m-trust__stat-label">Children Nurtured</span>
            <span class="m-trust__stat-sub">Early Years to High School</span>
          </div>
          <div class="m-trust__stat-card">
            <strong class="m-trust__stat-number">150+</strong>
            <span class="m-trust__stat-label">Passionate Gurus &amp; Staff</span>
            <span class="m-trust__stat-sub">1:8 Average Care Ratio</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
