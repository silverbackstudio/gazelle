<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

			<?php if(has_instagram() && apply_filters('show_instagram_footer', is_front_page())): ?>
			<section id="instagram">
				<header class="section-header">
					<h3 class="section-title"><?php _e('Check out our Instagram Gallery', 'gazelle'); ?></h3>
				</header>
				<div id="instafeed" class="section-content"></div>
			</section>
			<?php endif; ?>

		</div><!-- .site-content -->

		<footer id="colophon" class="site-footer full-width" role="contentinfo">

			<div class="site-info content-wrapper">
				<span class="site-title"><a class="screen-reader-text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
			</div><!-- .site-info -->
			
			<div class="site-info content-wrapper">
				<p><?php bloginfo('contact_address'); ?> <?php bloginfo('contact_address2'); ?><br /><a href="tel:<?php bloginfo('contact_phone'); ?>"><?php bloginfo('contact_phone'); ?></a><br/><?php echo hide_email(get_bloginfo('contact_email','display')); ?></a></p>
				<p><?php bloginfo('contact_company_name'); ?><br /><?php _e('VAT ID','gazelle'); ?>&nbsp;<?php bloginfo('contact_vat'); ?></p>
			</div><!-- .site-info -->
			
			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentysixteen' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'social',
							'menu_class'     => 'social-links-menu',
							'depth'          => 1,
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
						) );
					?>
				</nav><!-- .social-navigation -->
			<?php endif; ?>
			
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav class="service-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Legal Menu', 'twentysixteen' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'footer',
							'menu_class'     => 'footer-menu',
						 ) );
					?>
				</nav><!-- .main-navigation -->
			<?php endif; ?>			
			
			<div id="credits">Made by <a href="http://www.silverbackstudio.it" target="_blank" rel="external">SilverbackStudio</a></div>
		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
