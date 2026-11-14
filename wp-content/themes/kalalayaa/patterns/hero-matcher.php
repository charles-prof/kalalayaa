<?php
/**
 * Title: Hero with Interactive Campus Matcher
 * Slug: kalalayaa/hero-matcher
 * Categories: kalalayaa-hero
 * Description: Hero section introducing Kalalayaa with the interactive 2-select campus finder.
 *
 * @package Kalalayaa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"className":"l-section hero","layout":{"type":"constrained"}} -->
<section class="l-section hero" style="padding-block: var(--wp--preset--spacing--120, 96px) var(--wp--preset--spacing--80, 64px); background: radial-gradient(ellipse 60% 50% at 90% 20%, rgba(214, 232, 235, 0.5) 0%, transparent 70%), var(--wp--preset--color--teal-canvas);">
  <div class="l-container">
    <div class="l-grid-2col">

      <!-- Left Hero Narrative -->
      <div>
        <div style="display:inline-flex; align-items:center; gap:6px; padding:6px 16px; border-radius:9999px; background:#EEF7F9; color:#1B3942; font-size:14px; font-weight:600; border:1px solid #D6E8EB; margin-bottom:16px;">
          💖 "Living in millions of loving hearts"
        </div>

        <h1 style="font-size:clamp(32px, 5vw, 48px); margin-bottom:16px; line-height:1.15;">
          Where Little Hearts Blossom & <em style="color:#E0281D; font-style:italic;">Young Minds Excel</em>
        </h1>

        <p style="font-size:18px; color:#2A4F5A; margin-bottom:32px; max-width:540px;">
          From gentle toddler sanctuaries in Srirangam to our CBSE robotics and STEM laboratories at the E-Techno School, Kalalayaa gives children in Tiruchirappalli the warmth of home and the wings to fly.
        </p>

        <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:32px;">
          <a href="#campuses" class="wp-element-button" style="background:#0E2E35; color:white; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:600;">
            Explore Our 6 Campuses
          </a>
          <a href="#admissions" class="wp-element-button" style="background:white; color:#0E2E35; border:1px solid #D6E8EB; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:600;">
            Book a Warm Campus Visit
          </a>
        </div>

        <div style="display:flex; gap:24px; align-items:center; border-top:1px solid #D6E8EB; padding-top:20px; font-size:14px; font-weight:600; color:#2A4F5A;">
          <div>✓ 6 Campuses in Trichy</div>
          <div>✓ 1:8 Motherly Care Ratio</div>
          <div>✓ 9 Fine Arts Academies</div>
        </div>
      </div>

      <!-- Right Interactive Matcher Tool -->
      <div>
        <div class="m-matcher-card">
          <h2 class="m-matcher-card__title">Find Your Nearest Campus</h2>
          <p class="m-matcher-card__sub">Select your child's age and neighbourhood for instant counselor guidance.</p>

          <div class="m-matcher-card__field">
            <label class="m-matcher-card__label" for="matcherAge">Child's Stage / Age</label>
            <select class="m-matcher-card__select" id="matcherAge" onchange="window.kalalayaaUpdateMatcher()">
              <option value="toddler">Toddler & Playgroup (1.5 – 2.5 Yrs)</option>
              <option value="kindergarten" selected>Pre-KG, LKG & UKG (2.5 – 5.5 Yrs)</option>
              <option value="cbse">CBSE Primary & Middle School (Grade 1–8)</option>
              <option value="arts">Fine Arts & Hobby Classes (Ages 4–18)</option>
            </select>
          </div>

          <div class="m-matcher-card__field">
            <label class="m-matcher-card__label" for="matcherLocality">Your Neighbourhood in Trichy</label>
            <select class="m-matcher-card__select" id="matcherLocality" onchange="window.kalalayaaUpdateMatcher()">
              <option value="srirangam">Srirangam / Chithirai St / Ranga Nagar</option>
              <option value="kknagar" selected>K.K. Nagar / Sundar Nagar / Airport Area</option>
              <option value="cantonment">Cantonment / Collectorate / Thillai Nagar</option>
              <option value="crawford">Crawford Colony / Edamalaipatti Pudur</option>
              <option value="kailash">Kailash Nagar / Kattur / BHEL Area</option>
              <option value="etechno">Anywhere in Trichy (Looking for CBSE STEM)</option>
            </select>
          </div>

          <div class="m-matcher-result" id="matcherResult">
            <!-- Dynamically populated by matcher.js -->
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- /wp:group -->
