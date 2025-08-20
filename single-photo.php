<?php
get_header();

while ( have_posts() ) : the_post();
  $post_id   = get_the_ID();
  // Taxonomies
  $cats   = get_the_terms($post_id, 'categorie');
  $format = get_the_terms($post_id, 'format');
  // Custom fields (SCF/ACF)
  $type       = get_post_meta($post_id, 'type_photo', true);
  $reference  = get_post_meta($post_id, 'reference', true); // ex: NM-2023-014
  // Date prise de vue = date de publication (selon le brief)
  $annee      = get_the_date('Y', $post_id);
?>
<main id="single-photo__page" class="single-photo__page">
  <div class="single-photo__wrap">
    <!-- Colonne gauche : infos -->
    <aside class="single-photo__meta">
      <h2 class="single-photo__title"><?php the_title(); ?></h2>

      <ul class="single-photo__specs desc-photo">
        <?php if ($reference): ?>
          <li>RÉFÉRENCE : 
            <?php echo esc_html($reference); ?></li>
        <?php endif; ?>

        <?php if ($cats && !is_wp_error($cats)): ?>
          <li>CATÉGORIE :
            <?php echo esc_html( implode(', ', wp_list_pluck($cats, 'name')) ); ?>
          </li>
        <?php endif; ?>

        <?php if ($format && !is_wp_error($format)): ?>
          <li>FORMAT :
            <?php echo esc_html( implode(', ', wp_list_pluck($format, 'name')) ); ?>
          </li>
        <?php endif; ?>

        <?php if ($type): ?>
          <li>TYPE : 
            <?php echo esc_html($type); ?>
          </li>
        <?php endif; ?>

        <?php if ($annee): ?>
          <li>ANNÉE : 
            <?php echo esc_html($annee); ?>
          </li>
        <?php endif; ?>
      </ul>
    </aside>

    <!-- Colonne droite : visuel principal -->
    <figure class="single-photo__figure">
      <?php
        // image à la une en grand
        if ( has_post_thumbnail() ) {
          the_post_thumbnail('large', ['class' => 'single-photo__img']);
        }
      ?>
    </figure>
  </div>
  <!-- CTA contact -->
  <div class="separator-cta top"></div>
  <div class="single-photo__cta">
    <div class="single-photo-cta__container">
      <p>Cette photo vous intéresse ?</p>

      <button class="btn btn--contact js-open-contact"
      type="button" data-ref="<?php echo esc_attr($reference ?: get_the_title()); ?>"> Contact 
      </button>

    </div>
     <!-- Nav précédente / suivante (dans la même catégorie) -->
   <?php
    $prev_post = get_previous_post(true, '', 'categorie');
    $next_post = get_next_post(true, '', 'categorie');
    ?>
    <nav class="single-photo__nav">
      <!-- Boîte de preview unique -->
      <div class="preview-box">
        <?php if ($prev_post): ?>
          <?php echo get_the_post_thumbnail(
            $prev_post->ID, 'medium',
            ['class' => 'preview-img preview-prev']
          ); ?>
        <?php endif; ?>
        <?php if ($next_post): ?>
          <?php echo get_the_post_thumbnail(
            $next_post->ID, 'medium',
            ['class' => 'preview-img preview-next active']
          ); ?>
        <?php endif; ?>
      </div>
      <div class="nav-container">
          <?php if ($prev_post): ?>
              <a class="arrow-wrapper nav-prev"
                href="<?php echo esc_url(get_permalink($prev_post)); ?>"
                aria-label="Photo précédente : <?php echo esc_attr(get_the_title($prev_post)); ?>">
                  <span class="arrow arrow-left"></span>
              </a>
          <?php endif; ?>

          <?php if ($next_post): ?>
              <a class="arrow-wrapper nav-next"
                href="<?php echo esc_url(get_permalink($next_post)); ?>"
                aria-label="Photo suivante : <?php echo esc_attr(get_the_title($next_post)); ?>">
                  <span class="arrow arrow-right"></span>
              </a>
          <?php endif; ?>
      </div>
    </nav>
    </aside>
  </div>
  <div class="separator-cta bottom"></div>
  <!-- Section : Vous aimerez aussi (photos apparentées) -->
  <section class="related-photos">
    <h3 class="related-photos__title">Vous aimerez aussi</h3>
    <div class="related-photos__container">
      <?php
      $cat_ids = $cats ? wp_list_pluck($cats, 'term_id') : [];
      $q = new WP_Query([
        'post_type'      => 'photo',
        'post__not_in'   => [$post_id],
        'posts_per_page' => 2,
        'orderby'        => 'rand',
        'tax_query'      => $cat_ids ? [[
          'taxonomy' => 'categorie',
          'field'    => 'term_id',
          'terms'    => $cat_ids,
        ]] : [],
      ]);
      if ($q->have_posts()):
        while ($q->have_posts()): $q->the_post();
          get_template_part('template-parts/photo-card');
        endwhile;
        wp_reset_postdata();
      endif;
      ?>
    </div>
  </section>
</main>
<?php
endwhile;
get_footer();
