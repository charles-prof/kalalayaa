<?php
/**
 * Title: Moments of Joy Gallery
 * Slug: kalalayaa/moments-gallery
 * Categories: kalalayaa-hero
 * Description: Authentic photographic documentation of children, performances, and classrooms across campuses.
 *
 * @package Kalalayaa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$moments = array(
	array(
		'title'    => __( 'Classical Bharatanatyam Gurukulam', 'kalalayaa' ),
		'category' => __( 'Performing Arts', 'kalalayaa' ),
		'caption'  => __( 'Students in traditional salangai mastering classical mudras at the Srirangam heritage hall.', 'kalalayaa' ),
		'image'    => get_theme_file_uri( 'assets/photos/bharadanatiyam.jpg' ),
		'tag'      => __( 'Srirangam Campus', 'kalalayaa' ),
	),
	array(
		'title'    => __( 'Grand Annual Day Celebrations', 'kalalayaa' ),
		'category' => __( 'Celebration', 'kalalayaa' ),
		'caption'  => __( 'Over 600 children, parents, and teachers celebrating student achievements and artistic milestones.', 'kalalayaa' ),
		'image'    => get_theme_file_uri( 'assets/photos/annualdayfunctions.jpg' ),
		'tag'      => __( 'All Trichy Campuses', 'kalalayaa' ),
	),
	array(
		'title'    => __( 'Creative Movement & Dance Studio', 'kalalayaa' ),
		'category' => __( 'Early Arts', 'kalalayaa' ),
		'caption'  => __( 'Little learners developing rhythm, confidence, and posture in our padded dance sanctuary.', 'kalalayaa' ),
		'image'    => get_theme_file_uri( 'assets/photos/danceclass.jpg' ),
		'tag'      => __( 'K.K. Nagar Flagship', 'kalalayaa' ),
	),
	array(
		'title'    => __( 'Visual Arts, Painting & Color Theory', 'kalalayaa' ),
		'category' => __( 'Fine Arts', 'kalalayaa' ),
		'caption'  => __( 'Young artists exploring watercolours, acrylics, and clay modelling under master guidance.', 'kalalayaa' ),
		'image'    => get_theme_file_uri( 'assets/photos/finearts.jpg' ),
		'tag'      => __( 'Crawford & Kailash Nagar', 'kalalayaa' ),
	),
	array(
		'title'    => __( 'Acoustic Keyboard & Notation Lab', 'kalalayaa' ),
		'category' => __( 'Instrumental', 'kalalayaa' ),
		'caption'  => __( 'Students learning Trinity syllabus staff reading and finger tempo on professional keyboards.', 'kalalayaa' ),
		'image'    => get_theme_file_uri( 'assets/photos/musicclass.jpg' ),
		'tag'      => __( 'E-Techno & K.K. Nagar', 'kalalayaa' ),
	),
	array(
		'title'    => __( 'Carnatic Vocal & Sacred Slokas', 'kalalayaa' ),
		'category' => __( 'Vocal Arts', 'kalalayaa' ),
		'caption'  => __( 'Deep breathing, voice culture, and classical ragas nurturing clarity of speech and cultural pride.', 'kalalayaa' ),
		'image'    => get_theme_file_uri( 'assets/photos/vocalmusic.jpg' ),
		'tag'      => __( 'Cantonment & Srirangam', 'kalalayaa' ),
	),
);
?>
<!-- wp:group {"className":"l-section","layout":{"type":"constrained"}} -->
<section class="l-section" id="gallery">
  <div class="l-container">
    <div class="l-section__header">
      <span style="display:inline-flex; align-items:center; gap:6px; padding:4px 14px; border-radius:9999px; background:#EEF7F9; color:#1B3942; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:12px;">
        Life at Kalalayaa
      </span>
      <h2>Moments of Joy & Cultural Awakening</h2>
      <p>
        Real classrooms, real performances, and the genuine warmth of our children and teachers across Tiruchirappalli.
      </p>
    </div>

    <div class="l-grid-moments">
      <?php foreach ( $moments as $m ) : ?>
        <article class="m-moment-card">
          <div class="m-moment-card__image-wrap">
            <img src="<?php echo esc_url( $m['image'] ); ?>" alt="<?php echo esc_attr( $m['title'] ); ?>" loading="lazy">
            <span class="m-moment-card__tag"><?php echo esc_html( $m['tag'] ); ?></span>
          </div>
          <div class="m-moment-card__body">
            <div class="m-moment-card__category"><?php echo esc_html( $m['category'] ); ?></div>
            <h3 class="m-moment-card__title"><?php echo esc_html( $m['title'] ); ?></h3>
            <p class="m-moment-card__caption"><?php echo esc_html( $m['caption'] ); ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- /wp:group -->
