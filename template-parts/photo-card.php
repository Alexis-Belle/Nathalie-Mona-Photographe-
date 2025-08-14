<?php
// Dans la Loop
$post_id = get_the_ID();
$title   = get_the_title();
$ref     = get_post_meta($post_id, 'reference', true);
?>
<article class="photo-card">
  <a href="<?php the_permalink(); ?>" class="photo-card__link">
    <?php if ( has_post_thumbnail() ) :
      the_post_thumbnail('large', ['class' => 'photo-card__img']);
    endif; ?>
    <div class="photo-card__overlay">
      <div class="photo-card__title"><?php echo esc_html($title); ?></div>
      <?php if ($ref): ?>
        <div class="photo-card__ref"><?php echo esc_html($ref); ?></div>
      <?php endif; ?>
    </div>
  </a>
</article>
