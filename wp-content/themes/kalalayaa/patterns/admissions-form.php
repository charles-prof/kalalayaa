<?php
/**
 * Title: Admissions Desk with Smart Counselor Routing
 * Slug: kalalayaa/admissions-form
 * Categories: kalalayaa-admissions
 * Description: The reassuring 3-step admissions desk with deterministic campus routing.
 *
 * @package Kalalayaa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$campuses = kalalayaa_get_campus_registry();
?>
<!-- wp:group {"className":"l-section l-section--warm","layout":{"type":"constrained"}} -->
<section class="l-section l-section--warm" id="admissions">
  <div class="l-container">
    <div class="l-section__header">
      <span style="display:inline-flex; align-items:center; gap:6px; padding:4px 14px; border-radius:9999px; background:#EEF7F9; color:#1B3942; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:12px;">
        Admissions 2026-27
      </span>
      <h2>A Stress-Free Admissions Journey</h2>
      <p>Your inquiry is instantly routed to the right campus counselor — no mixed-up emails, no waiting for a generic support team.</p>
    </div>

    <div class="l-grid-admissions">

      <!-- Left Process Steps -->
      <div>
        <ol style="list-style:none; padding:0; margin:0 0 32px 0;">
          <li style="display:flex; gap:16px; margin-bottom:28px;">
            <div style="width:40px; height:40px; border-radius:50%; background:#EEF7F9; border:2px solid #D6E8EB; color:#0E2E35; font-weight:800; font-size:18px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
              1
            </div>
            <div>
              <div style="font-size:18px; font-weight:700; color:#0E2E35; margin-bottom:4px;">Submit Campus Application</div>
              <div style="font-size:14px; color:#2A4F5A; line-height:1.6;">Select your child's campus and program. Smart routing sends details directly to that campus's head counselor — not a generic inbox.</div>
            </div>
          </li>
          <li style="display:flex; gap:16px; margin-bottom:28px;">
            <div style="width:40px; height:40px; border-radius:50%; background:#EEF7F9; border:2px solid #D6E8EB; color:#0E2E35; font-weight:800; font-size:18px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
              2
            </div>
            <div>
              <div style="font-size:18px; font-weight:700; color:#0E2E35; margin-bottom:4px;">Personal Campus Walkthrough</div>
              <div style="font-size:14px; color:#2A4F5A; line-height:1.6;">Your counselor arranges a calm, pressure-free visit where your child explores play zones and meets future teachers at their own pace.</div>
            </div>
          </li>
          <li style="display:flex; gap:16px;">
            <div style="width:40px; height:40px; border-radius:50%; background:#EEF7F9; border:2px solid #D6E8EB; color:#0E2E35; font-weight:800; font-size:18px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
              3
            </div>
            <div>
              <div style="font-size:18px; font-weight:700; color:#0E2E35; margin-bottom:4px;">Gentle Orientation & Transition</div>
              <div style="font-size:14px; color:#2A4F5A; line-height:1.6;">We provide gradual separation support, child readiness kits, and direct parent-teacher communication from Day 1.</div>
            </div>
          </li>
        </ol>

        <div style="background:white; border-radius:16px; padding:24px; border:1px solid #D6E8EB;">
          <div style="font-weight:700; color:#0E2E35; margin-bottom:4px;">Need Immediate Guidance?</div>
          <div style="font-size:14px; color:#2A4F5A; margin-bottom:12px;">Call our central parent helpline or message on WhatsApp:</div>
          <a href="tel:+919443182910" style="font-weight:800; color:#0E2E35; text-decoration:none; font-size:20px; display:inline-block;">
            📞 +91 94431 82910
          </a>
        </div>
      </div>

      <!-- Right Admissions Form Card -->
      <div class="m-inquiry-card">
        <h3 class="m-inquiry-card__title">Online Admissions Desk</h3>
        <p class="m-inquiry-card__sub">Fill in the details below. Your application is personally acknowledged within 2 hours.</p>

        <form id="admissionsForm">
          <div class="m-form-row">
            <div class="m-form-group">
              <label class="m-form-label" for="parentName">
                Parent / Guardian Name <span class="req">*</span>
              </label>
              <input type="text" id="parentName" class="m-form-input" placeholder="e.g. Mrs. Lakshmi Ram" required autocomplete="name">
            </div>
            <div class="m-form-group">
              <label class="m-form-label" for="parentPhone">
                Mobile / WhatsApp <span class="req">*</span>
              </label>
              <input type="tel" id="parentPhone" class="m-form-input" placeholder="e.g. 98424 00000" required autocomplete="tel">
            </div>
          </div>

          <div class="m-form-row">
            <div class="m-form-group">
              <label class="m-form-label" for="childName">
                Child's Full Name <span class="req">*</span>
              </label>
              <input type="text" id="childName" class="m-form-input" placeholder="e.g. Ananya Ram" required>
            </div>
            <div class="m-form-group">
              <label class="m-form-label" for="childAge">
                Child's Age <span class="req">*</span>
              </label>
              <input type="text" id="childAge" class="m-form-input" placeholder="e.g. 3.5 Years" required>
            </div>
          </div>

          <div class="m-form-group">
            <label class="m-form-label" for="parentEmail">Email Address <span style="font-weight:400; color:#6B7280;">(optional)</span></label>
            <input type="email" id="parentEmail" class="m-form-input" placeholder="e.g. parent@example.com" autocomplete="email">
          </div>

          <div class="m-form-row">
            <div class="m-form-group">
              <label class="m-form-label" for="formCampus">
                Target Campus <span class="req">*</span>
              </label>
              <select id="formCampus" class="m-form-select" required onchange="window.kalalayaaUpdateFormRouting()">
                <?php foreach ( $campuses as $campus_id => $campus ) : ?>
                  <option value="<?php echo esc_attr( $campus_id ); ?>"><?php echo esc_html( $campus['name'] ); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="m-form-group">
              <label class="m-form-label" for="formProgram">
                Program of Interest <span class="req">*</span>
              </label>
              <select id="formProgram" class="m-form-select">
                <option value="Toddler Playgroup">Toddler Playgroup (1.5–2.5 Yrs)</option>
                <option value="Pre-KG / Nursery" selected>Pre-KG & Nursery (2.5–3.5 Yrs)</option>
                <option value="LKG / UKG Foundations">LKG / UKG (3.5–5.5 Yrs)</option>
                <option value="CBSE Grade 1–8">CBSE Grade 1–8 (E-Techno)</option>
                <option value="Fine Arts (Dance / Music / Art)">Fine Arts — Dance, Vocal, Art</option>
                <option value="Robotics, Chess & STEM">Robotics, Speedcubing & Chess</option>
                <option value="Executive Daycare Sanctuary">Daycare Sanctuary</option>
              </select>
            </div>
          </div>

          <!-- Dynamic Counselor Routing Feedback -->
          <div class="m-routing-preview" id="formRoutingPreview">
            <!-- Populated dynamically by admissions.js -->
          </div>

          <div class="m-form-group">
            <label class="m-form-label" for="formNotes">Special Notes or Questions</label>
            <textarea id="formNotes" class="m-form-textarea" placeholder="e.g. Looking for school bus from Thillai Nagar or afternoon daycare…"></textarea>
          </div>

          <button type="submit" class="wp-element-button" style="width:100%; min-height:48px; background:#0E2E35; color:white; font-size:16px; font-weight:600; border-radius:8px; cursor:pointer;">
            Send My Child's Application →
          </button>
        </form>
      </div>

    </div>
  </div>
</section>

<!-- Confirmation Modal -->
<div class="m-modal-backdrop" id="successModal" role="dialog" aria-modal="true" aria-label="Application Submitted">
  <div class="m-modal-box">
    <button class="m-modal-close" onclick="window.kalalayaaCloseModal('successModal')" aria-label="Close modal">✕</button>
    <div id="successModalBody">
      <!-- Populated dynamically -->
    </div>
  </div>
</div>
<!-- /wp:group -->
