<?php
/**
 * Title: Campus Admissions Form
 * Slug: kalalayaa/campus-admissions
 * Categories: kalalayaa-admissions
 * Description: Dedicated admissions inquiry form routed specifically to the active campus.
 */

$campus_id = Kalalayaa_Context::get_current_campus_id();
$campus    = kalalayaa_get_campus( $campus_id );

if ( ! $campus ) {
	$campus = kalalayaa_get_campus( 'kk-nagar' );
	$campus_id = 'kk-nagar';
}
?>
<section class="m-campus-inquiry" id="admissions">
  <div class="l-container">
    <div class="m-campus-inquiry__inner">
      <div class="m-campus-inquiry__header">
        <span class="m-campus-inquiry__eyebrow">Direct Application</span>
        <h2 class="m-campus-inquiry__title">Apply for Admission at <?php echo esc_html( $campus['name'] ); ?></h2>
        <p class="m-campus-inquiry__subtitle">
          Submit your child’s details directly to <strong><?php echo esc_html( $campus['counselor'] ); ?></strong>. We will arrange a personal walkthrough and answer all your questions.
        </p>
      </div>

      <form class="m-campus-inquiry__form" onsubmit="window.kalalayaaHandleAdmissionsSubmit(event)">
        <input type="hidden" name="campus_id" value="<?php echo esc_attr( $campus_id ); ?>">

        <div class="m-campus-inquiry__routing">
          <span class="m-campus-inquiry__routing-icon" aria-hidden="true">&#9889;</span>
          <p class="m-campus-inquiry__routing-text">
            <strong>Direct Routing:</strong> Inquiries are assigned instantly to <strong><?php echo esc_html( $campus['counselor'] ); ?></strong> (<?php echo esc_html( $campus['email'] ); ?>). No missed inquiries or generic call centers.
          </p>
        </div>

        <div class="m-campus-inquiry__row">
          <div class="m-campus-inquiry__field">
            <label class="m-campus-inquiry__label" for="inqParentName">Parent / Guardian Name *</label>
            <input class="m-campus-inquiry__input" type="text" id="inqParentName" name="parent_name" placeholder="e.g. S. Meenakshi" required>
          </div>
          <div class="m-campus-inquiry__field">
            <label class="m-campus-inquiry__label" for="inqPhone">Mobile Number (WhatsApp Preferred) *</label>
            <input class="m-campus-inquiry__input" type="tel" id="inqPhone" name="phone" placeholder="10-digit mobile number" required>
          </div>
        </div>

        <div class="m-campus-inquiry__row">
          <div class="m-campus-inquiry__field">
            <label class="m-campus-inquiry__label" for="inqChildName">Child’s Full Name *</label>
            <input class="m-campus-inquiry__input" type="text" id="inqChildName" name="child_name" placeholder="e.g. Aarav" required>
          </div>
          <div class="m-campus-inquiry__field">
            <label class="m-campus-inquiry__label" for="inqChildAge">Child’s Age / Stage *</label>
            <select class="m-campus-inquiry__select" id="inqChildAge" name="child_age" required>
              <option value="" disabled selected>Select age group</option>
              <option value="1.5 - 2.5 yrs">Playgroup / Toddler (1.5 – 2.5 yrs)</option>
              <option value="2.5 - 3.5 yrs">Pre-KG (2.5 – 3.5 yrs)</option>
              <option value="3.5 - 4.5 yrs">LKG (3.5 – 4.5 yrs)</option>
              <option value="4.5 - 5.5 yrs">UKG (4.5 – 5.5 yrs)</option>
              <option value="6 - 10 yrs">Primary Grades 1 – 5</option>
              <option value="11 - 15 yrs">Middle &amp; High School (CBSE STEM)</option>
              <option value="Arts Only">Fine Arts &amp; Music Only (Any Age)</option>
            </select>
          </div>
        </div>

        <div class="m-campus-inquiry__row">
          <div class="m-campus-inquiry__field">
            <label class="m-campus-inquiry__label" for="inqEmail">Email Address (Optional)</label>
            <input class="m-campus-inquiry__input" type="email" id="inqEmail" name="email" placeholder="name@domain.com">
          </div>
          <div class="m-campus-inquiry__field">
            <label class="m-campus-inquiry__label" for="inqProgram">Program of Interest</label>
            <input class="m-campus-inquiry__input" type="text" id="inqProgram" name="program" placeholder="e.g. Regular School, Daycare, Classical Dance">
          </div>
        </div>

        <div class="m-campus-inquiry__field">
          <label class="m-campus-inquiry__label" for="inqNotes">Special Notes or Questions for Counselor</label>
          <textarea class="m-campus-inquiry__textarea" id="inqNotes" name="notes" rows="3" placeholder="Tell us about your child's interests or preferred visit timing..."></textarea>
        </div>

        <button type="submit" class="m-campus-inquiry__submit">
          Submit Admissions Inquiry to <?php echo esc_html( $campus['name'] ); ?> &rarr;
        </button>
      </form>
    </div>
  </div>
</section>
