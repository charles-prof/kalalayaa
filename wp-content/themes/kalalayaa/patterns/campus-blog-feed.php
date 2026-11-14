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
	$campus = kalalayaa_get_campus( 'kk-nagar' );
	$campus_id = 'kk-nagar';
}

$campus_posts = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 3,
	'tax_query'      => array(
		array(
			'taxonomy' => 'campus',
			'field'    => 'slug',
			'terms'    => $campus_id,
		),
	),
) );
?>
<section class="m-campus-blog" id="events">
  <div class="l-container">
    <div class="m-campus-blog__header">
      <div>
        <span class="m-campus-blog__eyebrow">Life at <?php echo esc_html( $campus['name'] ); ?></span>
        <h2 class="m-campus-blog__title">Recent Events &amp; Celebrations</h2>
      </div>
      <a href="<?php echo esc_url( get_term_link( $campus_id, 'campus' ) ); ?>" class="m-campus-blog__all-link">
        View All <?php echo esc_html( $campus['name'] ); ?> Posts &rarr;
      </a>
    </div>

    <?php if ( $campus_posts->have_posts() ) : ?>
      <div class="m-campus-blog__grid">
        <?php
        while ( $campus_posts->have_posts() ) :
        	$campus_posts->the_post();
        ?>
          <article class="m-blog-card">
            <?php if ( has_post_thumbnail() ) : ?>
              <div class="m-blog-card__image-wrap">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail( 'medium_large', array( 'class' => 'm-blog-card__img' ) ); ?>
                </a>
              </div>
            <?php else : ?>
              <div class="m-blog-card__image-wrap m-blog-card__image-wrap--fallback">
                <a href="<?php the_permalink(); ?>">
                  <img src="<?php echo esc_url( $campus['image'] ); ?>"
                       alt="<?php the_title_attribute(); ?>"
                       class="m-blog-card__img"
                       loading="lazy">
                </a>
              </div>
            <?php endif; ?>

            <div class="m-blog-card__body">
              <div class="m-blog-card__meta">
                <time class="m-blog-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                  <?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
                </time>
                <span class="m-blog-card__dot">·</span>
                <span class="m-blog-card__author">By <?php the_author(); ?></span>
              </div>
              <h3 class="m-blog-card__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h3>
              <p class="m-blog-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?></p>
              <a href="<?php the_permalink(); ?>" class="m-blog-card__cta">Read Full Story &rarr;</a>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else : ?>
      <div class="m-campus-blog__empty">
        <p class="m-campus-blog__empty-text">
          Campus coordinators at <?php echo esc_html( $campus['name'] ); ?> are preparing upcoming festival and classroom celebration updates. Stay tuned!
        </p>
      </div>
    <?php endif; ?>
  </div>
</section>
