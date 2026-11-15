<?php
/**
 * Title: Campus Blog & Celebrations Feed
 * Slug: kalalayaa/campus-blog-feed
 * Categories: kalalayaa-campus
 * Description: Live feed of events, celebrations, and updates posted by campus staff.
 */

$campus_id = Kalalayaa_Context::get_current_campus_id();
$campus    = kalalayaa_get_campus( $campus_id );

if ( ! $campus ) {
	$campus    = kalalayaa_get_campus( 'kk-nagar' );
	$campus_id = 'kk-nagar';
}

$staff_login_url = wp_login_url( home_url( '/staff-portal/' ) );

$campus_posts = new WP_Query( array(
	'post_type'           => 'post',
	'posts_per_page'      => 6,
	'ignore_sticky_posts' => true,
	'tax_query'           => array(
		array(
			'taxonomy' => 'campus',
			'field'    => 'slug',
			'terms'    => $campus_id,
		),
	),
) );
?>
<section class="m-campus-news" id="campus-news">
  <div class="l-container">

    <div class="m-campus-news__header">
      <span class="m-campus-news__eyebrow">Campus Life &amp; Stories</span>
      <h2 class="m-campus-news__title">Latest from <?php echo esc_html( $campus['name'] ); ?></h2>
      <p class="m-campus-news__subtitle">Shared by our staff &mdash; recent events &amp; celebrations</p>
    </div>

    <?php if ( $campus_posts->have_posts() ) : ?>
      <div class="m-campus-news__grid">
        <?php
        while ( $campus_posts->have_posts() ) :
        	$campus_posts->the_post();
        	$campus_terms = get_the_terms( get_the_ID(), 'campus' );
        	$badge_text   = ( ! empty( $campus_terms ) && ! is_wp_error( $campus_terms ) ) ? $campus_terms[0]->name : $campus['name'];
        ?>
          <article class="m-campus-news__card">
            <?php if ( has_post_thumbnail() ) : ?>
              <div class="m-campus-news__card-thumb">
                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                  <?php the_post_thumbnail( 'medium_large', array( 'class' => 'm-campus-news__card-img', 'loading' => 'lazy' ) ); ?>
                </a>
                <span class="m-campus-news__card-badge"><?php echo esc_html( $badge_text ); ?></span>
              </div>
            <?php else : ?>
              <div class="m-campus-news__card-thumb m-campus-news__card-thumb--placeholder">
                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" class="m-campus-news__card-placeholder-link">
                  <span class="m-campus-news__card-placeholder-text">📸 No photo yet</span>
                </a>
                <span class="m-campus-news__card-badge"><?php echo esc_html( $badge_text ); ?></span>
              </div>
            <?php endif; ?>

            <div class="m-campus-news__card-body">
              <div class="m-campus-news__card-meta">
                <time class="m-campus-news__card-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                  <?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
                </time>
                <span class="m-campus-news__card-dot" aria-hidden="true">&bull;</span>
                <span class="m-campus-news__card-author">By <?php the_author(); ?></span>
              </div>

              <h3 class="m-campus-news__card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h3>

              <p class="m-campus-news__card-excerpt">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '...' ) ); ?>
              </p>

              <a href="<?php the_permalink(); ?>" class="m-campus-news__card-link">
                Read more &rarr;
              </a>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>

      <div class="m-campus-news__staff-cta">
        <a href="<?php echo esc_url( $staff_login_url ); ?>" class="m-campus-news__staff-btn">
          Staff Login to Share an Event &rarr;
        </a>
      </div>

    <?php else : ?>
      <div class="m-campus-news__empty">
        <div class="m-campus-news__empty-card">
          <p class="m-campus-news__empty-text">
            No events posted yet &mdash; <?php echo esc_html( $campus['name'] ); ?> staff, be the first to share a celebration!
          </p>
          <div class="m-campus-news__staff-cta m-campus-news__staff-cta--empty">
            <a href="<?php echo esc_url( $staff_login_url ); ?>" class="m-campus-news__staff-btn">
              Staff Login to Share an Event &rarr;
            </a>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>
