<?php

add_action('wp_enqueue_scripts', 'twentytwentyone_enqueue_assets');

function twentytwentyone_enqueue_assets() {
    // Style parent
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );

    // CSS principal
    wp_enqueue_style(
        'twentytwentyone-main-style',
        get_stylesheet_directory_uri() . '/assets/css/main.css',
        array('parent-style'),
        wp_get_theme()->get('Version')
    );

    // JS d'animation
    wp_enqueue_script(
        'twentytwentyone-animation-init',
        get_stylesheet_directory_uri() . '/assets/js/animation-init.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
