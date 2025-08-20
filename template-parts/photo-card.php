<div class="related-photos__item">
  <a class="related-photos__link" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
    <?php
    if ( has_post_thumbnail() ) {
      the_post_thumbnail('related-2col', ['class' => 'related-photos__img']);
    } else {
      the_post_thumbnail('large', ['class' => 'related-photos__img']);
    }
    ?>
  </a>
</div>
