<?php

add_action('wp_enqueue_scripts', function () {
    // CSS parent
    wp_enqueue_style(
        'twenty-twenty-one-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme(get_template())->get('Version')
    );

    // Polices Google (charger ensuite localement avec extension)
    wp_enqueue_style(
        'nm-google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        [],
        null
    );

    // CSS thème enfant
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/assets/css/main.css',
        [ 'twenty-twenty-one-style', 'nm-google-fonts' ],
        wp_get_theme()->get('Version')
    );

    // JS du thème enfant
    wp_enqueue_script(
        'twentytwentyone-script',
        get_stylesheet_directory_uri() . '/assets/js/script.js',
        [],
        wp_get_theme()->get('Version'),
        true
    );
}, 20);

function theme_register_menus() {
    register_nav_menu('main-menu', __('Menu d’accueil', 'text-domain'));
    register_nav_menu('footer-menu', __('Menu pied de page', 'text-domain'));
}
add_action('after_setup_theme', 'theme_register_menus');


// Charger le JS avec les variables Ajax
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script(
    'photos-ajax',
    get_stylesheet_directory_uri() . '/assets/js/photos-ajax.js',
    ['jquery'],
    null,
    true
  );

  wp_localize_script('photos-ajax', 'NM_AJAX', [
    'url'   => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('nm_photos_nonce'),
  ]);
});

add_action('wp_ajax_nm_get_photos', 'nm_get_photos');
add_action('wp_ajax_nopriv_nm_get_photos', 'nm_get_photos');

function nm_get_photos() {
  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'nm_photos_nonce')) {
    wp_send_json_error(['message' => 'Nonce invalide'], 403);
  }

  $page     = isset($_POST['page']) ? intval($_POST['page']) : 1;
  $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
  $format   = isset($_POST['format'])   ? sanitize_text_field($_POST['format'])   : '';
  $orderSel = isset($_POST['order'])    ? sanitize_text_field($_POST['order'])    : 'date_desc';

  // Tri
  $orderby = 'date';
  $order   = 'DESC';
  if ($orderSel === 'date_asc')  { $orderby = 'date';  $order = 'ASC'; }
  if ($orderSel === 'title_asc') { $orderby = 'title'; $order = 'ASC'; }
  if ($orderSel === 'title_desc'){ $orderby = 'title'; $order = 'DESC'; }

  $args = [
    'post_type'      => 'photo',
    'posts_per_page' => 8,
    'paged'          => $page,
    'orderby'        => $orderby,
    'order'          => $order,
  ];

  $tax_query = [];
  if ($category) $tax_query[] = ['taxonomy'=>'categorie','field'=>'slug','terms'=>$category];
  if ($format)   $tax_query[] = ['taxonomy'=>'format','field'=>'slug','terms'=>$format];
  if ($tax_query) $args['tax_query'] = $tax_query;

  $q = new WP_Query($args);

  ob_start();
  if ($q->have_posts()) {
    while ($q->have_posts()) { $q->the_post();
      get_template_part('template-parts/photo-card');
    }
  }
  wp_reset_postdata();
  $html = ob_get_clean();

  $has_more = ($q->max_num_pages > $page);

  wp_send_json_success([
    'html'     => $html,
    'hasMore'  => $has_more,
    'nextPage' => $page + 1,
  ]);
}
