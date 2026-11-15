<?php
/**
 * Template Name: News & Events Archive
 *
 * Comprehensive campus chronicle displaying stories, milestones, and
 * celebrations across all 6 Kalalayaa campuses with real-time campus filtering.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Fetch all 60 chronological posts
$all_posts = new WP_Query( array(
	'post_type'           => 'post',
	'posts_per_page'      => -1,
	'post_status'         => 'publish',
	'orderby'             => 'date',
	'order'               => 'DESC',
	'ignore_sticky_posts' => true,
) );

$campuses = kalalayaa_get_campus_registry();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php echo esc_url( get_theme_file_uri( 'assets/css/modules/news-events-page.css' ) ); ?>">
</head>
<body <?php body_class( 'page-news-events' ); ?>>

<?php block_template_part( 'header' ); ?>

<main class="m-news-page" id="primary">
  <div class="l-container">

    <!-- Hero Header -->
    <header class="m-news-hero">
      <span class="m-news-hero__eyebrow">
        <span class="m-news-hero__eyebrow-dot" aria-hidden="true"></span>
        <?php esc_html_e( 'Kalalayaa Chronicle • All 6 Campuses', 'kalalayaa' ); ?>
      </span>
      <h1 class="m-news-hero__title">
        <?php esc_html_e( 'News, Celebrations & Milestones', 'kalalayaa' ); ?>
      </h1>
      <p class="m-news-hero__subtitle">
        <?php esc_html_e( 'Authentic stories, classical arangetrams, science expos, and learning breakthroughs shared directly by our teachers and coordinators across Tiruchirappalli.', 'kalalayaa' ); ?>
      </p>
    </header>

    <!-- Interactive Campus Filter Pills -->
    <nav class="m-news-filter" aria-label="<?php esc_attr_e( 'Filter stories by campus', 'kalalayaa' ); ?>">
      <button type="button" class="m-news-filter__pill is-active" data-filter="all">
        <?php esc_html_e( 'All Campuses', 'kalalayaa' ); ?>
        <span class="m-news-filter__pill-count">(<?php echo esc_html( $all_posts->found_posts ); ?>)</span>
      </button>
      <?php foreach ( $campuses as $c_id => $c_data ) : ?>
        <button type="button" class="m-news-filter__pill" data-filter="<?php echo esc_attr( $c_id ); ?>">
          <?php echo esc_html( $c_data['name'] ); ?>
        </button>
      <?php endforeach; ?>
    </nav>

    <!-- Posts Grid -->
    <?php if ( $all_posts->have_posts() ) : ?>
      <div class="m-news-grid" id="news-grid">
        <?php
        while ( $all_posts->have_posts() ) :
        	$all_posts->the_post();
        	$terms = get_the_terms( get_the_ID(), 'campus' );
        	$campus_slug = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->slug : 'kk-nagar';
        	$campus_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : 'Kalalayaa';
        ?>
          <article class="m-news-card" data-campus="<?php echo esc_attr( $campus_slug ); ?>">
            <div class="m-news-card__thumb">
              <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'medium_large', array( 'class' => 'm-news-card__img', 'loading' => 'lazy' ) ); ?>
                <?php else : ?>
                  <div class="m-news-card__img-placeholder">📸</div>
                <?php endif; ?>
              </a>
              <span class="m-news-card__badge m-news-card__badge--<?php echo esc_attr( $campus_slug ); ?>">
                <?php echo esc_html( $campus_name ); ?>
              </span>
            </div>

            <div class="m-news-card__body">
              <div class="m-news-card__meta">
                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                  <?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
                </time>
                <span class="m-news-card__dot" aria-hidden="true">&bull;</span>
                <span>By <?php the_author(); ?></span>
              </div>

              <h2 class="m-news-card__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>

              <p class="m-news-card__excerpt">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '...' ) ); ?>
              </p>

              <a href="<?php the_permalink(); ?>" class="m-news-card__link">
                <?php esc_html_e( 'Read Full Story →', 'kalalayaa' ); ?>
              </a>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php endif; ?>

    <!-- Staff Educator Callout Banner -->
    <aside class="m-news-staff-banner" aria-label="<?php esc_attr_e( 'Staff Contributor Note', 'kalalayaa' ); ?>">
      <div class="m-news-staff-banner__text">
        <span class="m-news-staff-banner__icon" aria-hidden="true">✍️</span>
        <div>
          <h3 class="m-news-staff-banner__title"><?php esc_html_e( 'Are you a Kalalayaa Educator or Campus Coordinator?', 'kalalayaa' ); ?></h3>
          <p class="m-news-staff-banner__desc"><?php esc_html_e( 'Log into your branch portal to share photos, milestone celebrations, and classroom magic with parents.', 'kalalayaa' ); ?></p>
        </div>
      </div>
      <a href="<?php echo esc_url( home_url( '/staff-portal/' ) ); ?>" class="m-news-staff-banner__btn">
        <?php esc_html_e( 'Open Staff Portal →', 'kalalayaa' ); ?>
      </a>
    </aside>

  </div>
</main>

<script>
(function() {
  'use strict';
  document.addEventListener('DOMContentLoaded', function() {
    var pills = document.querySelectorAll('.m-news-filter__pill');
    var cards = document.querySelectorAll('.m-news-card');

    function applyFilter(targetCampus) {
      pills.forEach(function(pill) {
        pill.classList.toggle('is-active', pill.getAttribute('data-filter') === targetCampus);
      });

      cards.forEach(function(card) {
        var cardCampus = card.getAttribute('data-campus');
        if (targetCampus === 'all' || cardCampus === targetCampus) {
          card.classList.remove('is-hidden');
        } else {
          card.classList.add('is-hidden');
        }
      });
    }

    pills.forEach(function(pill) {
      pill.addEventListener('click', function() {
        var filter = this.getAttribute('data-filter');
        applyFilter(filter);
        if (filter !== 'all') {
          history.replaceState(null, '', '#' + filter);
        } else {
          history.replaceState(null, '', window.location.pathname);
        }
      });
    });

    // Handle initial hash in URL (e.g. /news-events/#srirangam)
    if (window.location.hash) {
      var initialCampus = window.location.hash.substring(1);
      var matchingPill = document.querySelector('.m-news-filter__pill[data-filter="' + initialCampus + '"]');
      if (matchingPill) {
        applyFilter(initialCampus);
      }
    }
  });
})();
</script>

<?php block_template_part( 'footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
