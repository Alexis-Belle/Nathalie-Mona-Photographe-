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
        'https://fonts.googleapis.com/css2?family=Poppins:wght@300&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap',
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
