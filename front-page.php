<?php
get_header();
?>
<main id="front-page" class="front-page">
<section class="hero">
    <h1 class="hero__title">PHOTOGRAPHE EVENT</h1>
</section>

  <section class="home-photos">

    <!-- Filtres dynamiques -->
    <form id="photo-filters" class="photo-filters">
      <?php
      // Catégories (taxonomy: categorie_photo)
      $cats = get_terms([
        'taxonomy'   => 'categorie',
        'hide_empty' => true,
      ]);
      ?>
      <div class="left-filter-container">
        <select id="filter-category" name="category">
          <option value="">Catégories</option>
          <?php foreach ($cats as $t): ?>
            <option value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
          <?php endforeach; ?>
        </select>

      <?php
      // Formats (taxonomy: format_photo)
      $fmts = get_terms([
        'taxonomy'   => 'format',
        'hide_empty' => true,
      ]);
      ?>
        <select id="filter-format" name="format">
          <option value="">Formats</option>
          <?php foreach ($fmts as $t): ?>
            <option value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="right-filter-container">
        <select id="filter-order" name="order">
          <option value="">Triez Par</option>
          <option value="date_desc">Plus récents</option>
          <option value="date_asc">Plus anciens</option>
          <option value="title_asc">Titre A→Z</option>
          <option value="title_desc">Titre Z→A</option>
        </select>
      </div>
    </form>

    <div id="photo-grid" class="home-photos__container">
      <?php
      $q = new WP_Query([
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => 1,
      ]);

      if ($q->have_posts()) :
        while ($q->have_posts()) : $q->the_post();
          get_template_part('template-parts/photo-card');
        endwhile;
        wp_reset_postdata();
      endif;
      ?>
    </div>

    <div class="load-more-wrap">
      <button id="load-more" class="load-more__btn" type="button">Charger plus</button>
    </div>

  </section>


<?php
get_footer();
