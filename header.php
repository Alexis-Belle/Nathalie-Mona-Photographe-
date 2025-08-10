<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content">
        <?php esc_html_e('Skip to content', 'twentytwentyone'); ?>
    </a>

    <header id="masthead" class="site-header">
        <!-- Logo et menu -->
        <div class="header-inner">
            <div class="site-branding">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php bloginfo('name'); ?>">
                </a>
            </div>
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Menu principal', 'text-domain'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'container'      => false,
                    'menu_class'     => 'menu',
                    'fallback_cb'    => false
                ]);
                ?>
            </nav>
        </div>
    </header>

    <div id="content" class="site-content">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
