<?php
get_header();
?>
<main id="front-page" class="front-page">
<section class="hero">
    <h1 class="hero__title">PHOTOGRAPHE EVENT</h1>
</section>

<section class="home-photos">
    <button>En attendant je met un bouton</button>
  <div class="home-photos__container">
    <?php
    $q = new WP_Query([
      'post_type'      => 'photo',
      'posts_per_page' => 8,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ]);

    if ( $q->have_posts() ) :
      while ( $q->have_posts() ) : $q->the_post();
        get_template_part('template-parts/photo-card');
      endwhile;
      wp_reset_postdata();
    endif;
    ?>
  </div>
</section>


<?php
get_footer();
