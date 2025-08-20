
<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content">
		<?php
		/* translators: Hidden accessibility text. */
		esc_html_e( 'Skip to content', 'twentytwentyone' );
		?>
	</a>

	<nav class="nm-nav" role="navigation" aria-label="<?php esc_attr_e('Menu principal', 'text-domain'); ?>">
        <div class="container-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo-nathalie-mota.png" alt="Nathalie Mota" class="site-logo">
            </a>
        </div>
        <div class="container-liens">
            <?php
            wp_nav_menu([
                'theme_location' => 'main-menu',
                'container'      => false,
                'menu_class'     => 'nm-menu',
                'fallback_cb'    => false
            ]);
            ?>
        </div>

        <div class="menu-container">
            <button class="menu-toggle" aria-controls="nm-menu-overlay" aria-expanded="false" aria-label="<?php esc_attr_e('Ouvrir le menu', 'text-domain'); ?>">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </button>
        </div>
    </nav>

    <!-- Overlay -->
    <div id="nm-menu-overlay" class="menu-header" hidden aria-hidden="true">
    <?php
        wp_nav_menu([
            'theme_location' => 'main-menu',
            'container'      => false,
            'menu_class'     => 'menu-overlay',
            'fallback_cb'    => false
        ]);
    ?>
    </div>

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
