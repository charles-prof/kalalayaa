<?php
/**
 * Title: Blog Card
 * Slug: kalalayaa/blog-card
 * Categories: kalalayaa-campus
 * Description: Clean blog post card for archive grids.
 * Block Types: core/post-template
 */
?>
<article class="m-blog-card">
  <!-- wp:post-featured-image {"className":"m-blog-card__image","isLink":true} /-->
  <div class="m-blog-card__body">
    <div class="m-blog-card__meta">
      <!-- wp:post-date {"className":"m-blog-card__date","format":"M j, Y"} /-->
      <!-- wp:post-terms {"term":"campus","className":"m-blog-card__campus-tag"} /-->
    </div>
    <!-- wp:post-title {"level":3,"isLink":true,"className":"m-blog-card__title"} /-->
    <!-- wp:post-excerpt {"moreText":"Read More →","excerptLength":20,"className":"m-blog-card__excerpt"} /-->
  </div>
</article>
