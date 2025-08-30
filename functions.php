<?php

add_action('wp_enqueue_scripts', function () {
    $theme_version = wp_get_theme()->get('Version');

    //  STYLES
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme(get_template())->get('Version')
    );

    wp_enqueue_style(
        'nm-google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'child-style',
        get_theme_file_uri('/assets/css/main.css'),
        ['parent-style', 'nm-google-fonts'],
        $theme_version
    );

    // SCRIPTS PRINCIPAUX
    wp_enqueue_script(
        'child-script', // JS principal
        get_theme_file_uri('/assets/js/script.js'),
        [],
        $theme_version,
        true
    );

    // Lightbox
    wp_enqueue_script(
        'lightbox',
        get_theme_file_uri('/assets/js/lightbox.js'),
        [],
        '1.0',
        true
    );

    // Photos Ajax
    wp_enqueue_script(
        'photos-ajax',
        get_theme_file_uri('/assets/js/photos-ajax.js'),
        ['jquery'],
        $theme_version,
        true
    );

    // Variables passées à Ajax (URL & sécurité)
    wp_localize_script('photos-ajax', 'NM_AJAX', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nm_photos_nonce'),
    ]);
}, 20);


// MENUS

add_action('after_setup_theme', function () {
    register_nav_menu('main-menu', __('Menu d’accueil', 'text-domain')); // Menu principal
    register_nav_menu('footer-menu', __('Menu pied de page', 'text-domain')); // Menu pied de page
});



// AJAX - CHARGEMENT DES PHOTOS

// Enregistre les actions Ajax (utilisateur connecté et non connecté)
add_action('wp_ajax_nm_get_photos', 'nm_get_photos');
add_action('wp_ajax_nopriv_nm_get_photos', 'nm_get_photos');

function nm_get_photos() {
    // Vérification sécurité nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'nm_photos_nonce')) {
        wp_send_json_error(['message' => 'Nonce invalide'], 403);
    }

    // Récupération et nettoyage des paramètres
    $page     = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = sanitize_text_field($_POST['category'] ?? '');
    $format   = sanitize_text_field($_POST['format'] ?? '');
    $orderSel = sanitize_text_field($_POST['order'] ?? 'date_desc');

    // Définir ordre de tri
    $orderby = 'date';
    $order   = 'DESC';
    if ($orderSel === 'date_asc')  { $orderby = 'date';  $order = 'ASC'; }
    if ($orderSel === 'title_asc') { $orderby = 'title'; $order = 'ASC'; }
    if ($orderSel === 'title_desc'){ $orderby = 'title'; $order = 'DESC'; }

    // Préparation de la requête WP_Query
    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $page,
        'orderby'        => $orderby,
        'order'          => $order,
    ];

    // Ajout des taxonomies si filtrées
    $tax_query = [];
    if ($category) $tax_query[] = ['taxonomy' => 'categorie', 'field' => 'slug', 'terms' => $category];
    if ($format)   $tax_query[] = ['taxonomy' => 'format',    'field' => 'slug', 'terms' => $format];
    if (!empty($tax_query)) $args['tax_query'] = $tax_query;

    // Exécution de la requête
    $q = new WP_Query($args);

    // Capture le HTML généré
    ob_start();
    if ($q->have_posts()) {
        while ($q->have_posts()) { 
            $q->the_post();
            get_template_part('template-parts/photo-card'); // Template de chaque photo
        }
    }
    wp_reset_postdata();
    $html = ob_get_clean();

    // Réponse JSON
    wp_send_json_success([
        'html'     => $html,
        'hasMore'  => ($q->max_num_pages > $page), // Y a-t-il d'autres pages ?
        'nextPage' => $page + 1,
    ]);
}
