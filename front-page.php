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
      // Catégories
      $cats = get_terms([
        'taxonomy'   => 'categorie',
        'hide_empty' => true,
      ]);
      // Formats
      $fmts = get_terms([
        'taxonomy'   => 'format',
        'hide_empty' => true,
      ]);
      ?>

      <!-- Inputs cachés lus par le JS Ajax (mêmes IDs qu'avant) -->
      <input type="hidden" id="filter-category" name="category" value="">
      <input type="hidden" id="filter-format"   name="format"   value="">
      <input type="hidden" id="filter-order"    name="order"    value="date_desc">

      <div class="left-filter-container">
        <!-- Catégories -->
      <ul class="filter-list" data-target="#filter-category" role="listbox" aria-label="Catégories">
          <li class="filter-item is-label is-active" data-value="">Catégories</li>
        <li class="filter-item" data-value="">- Par Défaut -</li>
        <?php foreach ($cats as $t): ?>
          <li class="filter-item" data-value="<?php echo esc_attr($t->slug); ?>">
            <?php echo esc_html($t->name); ?>
          </li>
        <?php endforeach; ?>
        </ul>

        <!-- Formats -->
        <ul class="filter-list" data-target="#filter-format" role="listbox" aria-label="Formats">
          <li class="filter-item is-active" data-value="">Formats</li>
          <li class="filter-item" data-value="">- Par Défaut -</li>
          <?php foreach ($fmts as $t): ?>
            <li class="filter-item" data-value="<?php echo esc_attr($t->slug); ?>">
              <?php echo esc_html($t->name); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="right-filter-container">
        <!-- Tri -->
        <ul class="filter-list" data-target="#filter-order" role="listbox" aria-label="Triez par">
          <li class="filter-item is-label is-active" data-value="">Triez par</li>        
          <li class="filter-item" data-value="date_desc">Plus récents</li>
          <li class="filter-item" data-value="date_asc">Plus anciens</li>
          <li class="filter-item" data-value="title_asc">Titre A→Z</li>
          <li class="filter-item" data-value="title_desc">Titre Z→A</li>
        </ul>
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
</main>
<?php
get_footer();
?>