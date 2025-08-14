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
        // image à la une en grand – adapter la taille (ex: 'full' optimisé)
        if ( has_post_thumbnail() ) {
          the_post_thumbnail('large', ['class' => 'single-photo__img']);
        }
      ?>
    </figure>
  </div>
  <!-- CTA contact -->
  <div class="single-photo__cta">
    <p>Cette photo vous intéresse ?</p>
    <button class="btn btn--contact js-open-contact"
            data-ref="<?php echo esc_attr($reference ?: get_the_title()); ?>">
      Contact
    </button>
  </div>
  <!-- Section : Vous aimerez aussi (photos apparentées) -->
  <section class="related-photos">
    <h2 class="related-photos__title">Vous aimerez aussi</h2>
    <div class="related-photos__grid">
      <?php
        // Récupère les catégories du post courant
        $cat_ids = $cats ? wp_list_pluck($cats, 'term_id') : [];
        $q = new WP_Query([
          'post_type'      => 'photo',
          'post__not_in'   => [$post_id],
          'posts_per_page' => 2,              // maquette : 2 éléments
          'orderby'        => 'rand',
          'tax_query'      => $cat_ids ? [[
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => $cat_ids,
          ]] : [],
        ]);

        if ( $q->have_posts() ) :
          while ( $q->have_posts() ) : $q->the_post();
            get_template_part('template-parts/photo-card'); // réutilisable
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
