<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
		</div><!-- #primary -->
	</div><!-- #content -->

	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<footer id="colophon" class="main-footer">
    <div class="footer-container">
		<?php
		wp_nav_menu([
		'theme_location' => 'footer-menu',
		'container'      => false,
		'menu_class'     => 'footer-menu',
		'depth'          => 1
		]);
		?>
    </div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<div id="lb" class="lb lb--hidden">
  <div class="lb__overlay" data-close="1"></div>
  <button class="lb__btn lb__btn--close" data-close="1" aria-label="Fermer"><img src="<?php echo esc_url( get_stylesheet_directory_uri().'/assets/images/croix-icon.svg' ); ?>" alt=""></button>

      <div class="lb__wrap">
          <!-- Flèche gauche -->
        <div class="lb__container-left">
          <button class="lb__arrow lb__arrow--prev" aria-label="Précédente">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri().'/assets/images/arrow-left.svg' ); ?>" alt="">
            <span>Précédente</span>
          </button>
        </div>

        <div class="lb__wrap-photo-info">
          <img class="lb__img" alt="">
          <div class="lb__bar">
            <span class="lb__ref"></span>
            <span class="lb__cat"></span>
          </div>
        </div>

        <!-- Flèche droite -->
      <div class="lb__container-right">
        <button class="lb__arrow lb__arrow--next" aria-label="Suivante">
          <span>Suivante</span>
          <img src="<?php echo esc_url( get_stylesheet_directory_uri().'/assets/images/arrow-right.svg' ); ?>" alt="">
        </button>
      </div>
          <!-- Flèche gauche et droite -->
        <div class="lb__mobile-container-arrows">
          <button class="lb__arrow lb__arrow--prev" aria-label="Précédente">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri().'/assets/images/arrow-left.svg' ); ?>" alt="">
            <span>Précédente</span>
          </button>
          <button class="lb__arrow lb__arrow--next" aria-label="Suivante">
            <span>Suivante</span>
            <img src="<?php echo esc_url( get_stylesheet_directory_uri().'/assets/images/arrow-right.svg' ); ?>" alt="">
          </button>
        </div>
  </div>
</div>


<?php wp_footer(); ?>
<?php get_template_part('template-parts/modal-contact'); ?>
</body>
</html>