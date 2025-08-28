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

  <?php
    $id       = get_the_ID();
    $full_src = get_the_post_thumbnail_url($id, 'full');

    // Référence (ACF ou meta classique : adapte la clé si besoin)
    $reference = get_post_meta($id, 'reference', true);
    if (!$reference) { $reference = get_the_title($id); } // fallback simple

    // Catégorie (taxonomie 'categorie'), on prend la 1ère si plusieurs
    $terms = get_the_terms($id, 'categorie');
    $cat_name = ($terms && !is_wp_error($terms)) ? $terms[0]->name : '';
  ?>

  <!-- Oeil vers la fiche -->
  <a class="related-photos__eye" href="<?php the_permalink(); ?>" aria-label="Voir la fiche">
    <img class="eye-icon" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/eye.svg' ); ?>" alt="">
  </a>

  <!-- Plein écran (LIGHTBOX) -->
  <a class="related-photos__fullscreen"
     href="<?php echo esc_url($full_src); ?>"
     data-lightbox
     data-src="<?php echo esc_url($full_src); ?>"
     data-title="<?php echo esc_attr(get_the_title()); ?>"
     data-ref="<?php echo esc_attr($reference); ?>"
     data-cat="<?php echo esc_attr($cat_name); ?>"
     aria-label="Voir en plein écran">
     ⛶
  </a>
</div>
